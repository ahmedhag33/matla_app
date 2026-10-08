<?php

namespace App\Http\Controllers\Client\Auth;

use App\Exceptions\AuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Auth\VerfiyRequest;
use App\Jobs\Client\SendToUserVerifcationMail;
use App\Models\VerificationCode;
use App\Service\Base\JsonAPIMessages;
use App\Service\Enum\HttpStatusCode;
use App\Service\Enum\VerificationActionType;
use App\Service\Enum\VerificationType;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;

class VerifcationController extends Controller
{
    use JsonAPIMessages;
    /**
     * Verify the user's email address.
     *
     * @param VerfiyRequest $request
     * @return \Illuminate\Http\JsonResponse|void|string
     * @throws HttpResponseException
     * @throws \Exception
     * @throws AuthException
     */
    public function verify(VerfiyRequest $request)
    {
        try {
            $verificationCode = $request->input('verification_code');
            // Get the authenticated user
            $user = (object) auth()->user();
            // Get the latest verification code
            $verificationCodeQuery = $user->verificationCodes()
                ->where('type', VerificationType::EMAIL->value)
                ->where('action_type', VerificationActionType::REGISTER->value)
                ->whereNull('verified_at')
                ->where('expires_at', '>', now())
                ->latest()
                ->first();
            // if verification code not found
            if (!$verificationCodeQuery || !Hash::check($verificationCode, $verificationCodeQuery->code)) {
                throw new AuthException(__('Verification code not found.'), HttpStatusCode::FORBIDDEN->value);
            }
            // update verification code
            $verificationCodeQuery->update(['verified_at' => now()]);
            // update user
            $user->update(['email_verified_at' => now()]);
            // put success message in session
            session()->flash('success-message-user-verify', __('Email verified successfully.'));
            // send success response
            return $this->returnData([
                'success' => true,
                'message' => __('Email verified successfully.'),
                'url' => lastUrl('is_verify=1') ?? route('index-page', ['is_verify' => 1]),
            ]);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (AuthException $e) {
            return $this->errorException($e->getCode(), $e->getMessage());
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, $e->getMessage());
        }
    }
    /**
     * Resend the verification code to the user's email.
     *
     * @return \Illuminate\Http\JsonResponse|void|string
     * @throws HttpResponseException
     * @throws \Exception
     * @throws AuthException
     */
    public function resend()
    {
        try {
            $user = (object) auth()->user();
            // create verification code
            $create = (object) runTransaction(function () use ($user) {
                $createverficationCode = VerificationCode::create([
                    'user_id' => $user->id,
                    'type' => VerificationType::EMAIL->value,
                    'action_type' => VerificationActionType::REGISTER->value,
                ]);
                return $createverficationCode;
            });
            session()->put('verification-timer', $create->expires_at->toISOString());
            // send verification code to user email
            dispatch(new SendToUserVerifcationMail($user->email, __('Activation Code is') . ' ' . $create->code))->delay(now()->addSeconds(5));
            // send success response
            return $this->returnData([
                'success' => true,
                'message' => __('Verification code sent successfully.'),
                'verification_code' => $create->code,
                'timer' => $create->expires_at->toISOString(),
            ]);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (AuthException $e) {
            return $this->errorException($e->getCode(), $e->getMessage());
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, $e->getMessage());
        }
    }
}

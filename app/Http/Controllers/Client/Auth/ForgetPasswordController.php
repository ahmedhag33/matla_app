<?php

namespace App\Http\Controllers\Client\Auth;

use App\Exceptions\AuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Auth\ForgetRequest;
use App\Http\Requests\Client\Auth\ResetPassordRequest;
use App\Http\Requests\Client\Auth\VerfiyRequest;
use App\Jobs\Client\SendToUserVerifcationMail;
use App\Models\User;
use App\Models\VerificationCode;
use App\Service\Base\JsonAPIMessages;
use App\Service\Enum\HttpStatusCode;
use App\Service\Enum\VerificationActionType;
use App\Service\Enum\VerificationType;
use Hash;
use Illuminate\Http\Exceptions\HttpResponseException;

class ForgetPasswordController extends Controller
{
    use JsonAPIMessages;

    /**
     * Handle the incoming request to send a password reset email.
     *
     * @param ForgetRequest $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws \Exception
     * @throws AuthException
     * @throws HttpResponseException
     */
    public function forget(ForgetRequest $request)
    {
        try {
            $email = $request->input('email');
            // check if email exist
            if (!in_array($email, User::pluck('email')->toArray())) {
                throw new AuthException(
                    __('Email does not exist in our records'),
                    HttpStatusCode::UNAUTHORIZED->value
                );
            }
            // set verification code and send email
            $code = (string) random_int(100000, 999999);
            // store email in session to use it in the next step
            session()->put('email', $email);
            // store verification code in database
            $vercificationCode = (object) runTransaction(function () use ($code, $email) {
                $verificationCode = VerificationCode::create([
                    'code' => createHash($code),
                    'email' => $email,
                    'type' => VerificationType::EMAIL->value,
                    'action_type' => VerificationActionType::RESET_PASSWORD->value,
                ]);
                // return verification code
                return $verificationCode;
            });
            // sent email to user with verification code
            dispatch(new SendToUserVerifcationMail($email, __('Activation Code is') . ' ' . $code))->delay(now()->addSeconds(10));
            // return response to client
            return $this->returnData([
                'message' => __('Verification code sent to your email'),
                'success' => true,
                'email' => $email,
                'timer' => $vercificationCode->expires_at->toISOString(),
            ]);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, __('An error occurred'));
        } catch (AuthException $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, $e->getMessage());
        }
    }
    /**
     * Handle the incoming request to verify the code sent to the user's email.
     *
     * @param VerfiyRequest $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws \Exception
     * @throws \invalidArgumentException
     */
    public function sendCode(VerfiyRequest $request)
    {
        try {
            // get verification code
            $vercificationCode = VerificationCode::where('email', session()->get('email'))
                ->where('type', VerificationType::EMAIL->value)
                ->where('action_type', VerificationActionType::RESET_PASSWORD->value)
                ->whereNull('verified_at')
                ->where('expires_at', '>', now())
                ->latest()
                ->first();
            // check if code exist
            if (!$vercificationCode || !Hash::check($request->input('verification_code'), $vercificationCode->code)) {
                throw new AuthException(__('Verification code is invalid'), HttpStatusCode::UNAUTHORIZED->value);
            }
            // update verification code
            $vercificationCode->update(['verified_at' => now()]);
            // return response to client
            return $this->returnData(['message' => __('Email verified successfully.'), 'success' => true]);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, $e->getMessage());
        } catch (AuthException $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, $e->getMessage());
        }
    }
    /**
     * Handle the incoming request to reset the user's password.
     *
     * @param ResetPassordRequest $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws \Exception
     * @throws \invalidArgumentException
     */
    public function resetPassord(ResetPassordRequest $request)
    {
        try {
            // get email from session
            $email = session()->get('email');
            // find user by email
            $user = (object) User::where('email', $email)->first();
            // update password
            $user->password = createHash($request->input('password'));
            // update user
            $user->save();
            // attempt to login
            $attempt = ['email' => $email, 'password' => $request->input('password')];
            // check if login attempt is successful
            if (auth()->guard()->attempt($attempt)) {
                // clear email
                session()->forget('email');
                // return response to client
                $data = ['message' => __('Login Success'), 'url' => route('index-page')];
                // put login success message in session
                session()->flash('login-success', __('Login Success'));
                // return data to the user
                return $this->returnData($data);
            } else {
                throw new AuthException(__('Login Failed'), HttpStatusCode::FORBIDDEN->value);
            }
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, __('An error occurred'));
        } catch (AuthException $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, $e->getMessage());
        }
    }
}

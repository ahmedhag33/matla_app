<?php

namespace App\Http\Controllers\Client\User;

use App\Exceptions\AuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\User\UpdateEmailRequest;
use App\Http\Requests\Client\User\UpdatePassordRequest;
use App\Http\Requests\Client\User\UpdateUserRequest;
use App\Jobs\Client\SendToUserVerifcationMail;
use App\Models\VerificationCode;
use App\Service\Base\JsonAPIMessages;
use App\Service\Enum\HttpStatusCode;
use App\Service\Enum\VerificationActionType;
use App\Service\Enum\VerificationType;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use JsonAPIMessages;
    /**
     * Display the user's profile.
     *
     * @return \Illuminate\View\View
     */
    public function profile()
    {
        return view('client.user.profile');
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function updatePhoto(Request $request)
    {
        try {
            $user = auth()->user();
            // update user
            $user->update(
                ['photo' => UploadWithOutStorage('client/img/', $request->file('photo')),]
            );
            // flash success message
            session()->flash('update-photo-message', __('Image Updated Successfully'));
            // return data
            return $this->returnData(['success' => true, 'message' => __('Image Updated Successfully'), 'url' => route('user.profile')]);
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, __('An error occurred'));
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateUserRequest  $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws \Exception
     */
    public function updateProfile(UpdateUserRequest $request)
    {
        try {
            $user = auth()->user();
            // update user
            $user->update(
                ['name' => $request->input('name')]
            );
            // flash success message
            session()->flash('update-profile-message', __('Profile Updated Successfully'));
            // return data
            return $this->returnData(['success' => true, 'message' => __('Profile Updated Successfully'), 'url' => route('user.profile')]);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, __('An error occurred'));
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateEmailRequest  $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws \Exception
     */
    public function editEmail(UpdateEmailRequest $request)
    {
        try {
            $code = (string) random_int(100000, 999999);
            // get user
            $user = auth()->user();
            // get email from request
            $email = $request->input('email');
            // check if email is the same as the current email
            if ($email == $user->email) {
                throw new AuthException(__('The Email is the same as the current email'), HttpStatusCode::BAD_REQUEST->value);
            }
            $create = (object) runTransaction(function () use ($email, $user, $code) {
                $create = VerificationCode::create([
                    'user_id' => $user->id,
                    'email' => $email,
                    'code' => createHash($code),
                    'type' => VerificationType::EMAIL->value,
                    'action_type' => VerificationActionType::UPDATE_EMAIL->value,
                ]);
                return $create;
            });
            // send verification code to user email
            dispatch(new SendToUserVerifcationMail($create->email, __('Activation Code is') . ' ' . $code))->delay(now()->addSeconds(5));
            // return data
            return $this->returnData([
                'success' => true,
                'message' => __('Activation Code is sent to your email'),
                'timer' => $create->expires_at->toISOString(),
            ]);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (AuthException $e) {
            return $this->errorException($e->getCode(), $e->getMessage());
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, __('An error occurred'));
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateEmailRequest  $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws \Exception
     */
    public function updateEmail(Request $request)
    {
        try {
            $verificationCode = $request->input('verification_code');
            // Get the authenticated user
            $user = (object) auth()->user();
            // Get the latest verification code
            $verificationCodeQuery = $user->verificationCodes()
                ->where('type', VerificationType::EMAIL->value)
                ->where('action_type', VerificationActionType::UPDATE_EMAIL->value)
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
            $user->update(['email' => $verificationCodeQuery->email]);
            // put success message in session
            session()->flash('success-update-email', __('Email verified successfully.'));
            // send success response
            return $this->returnData([
                'success' => true,
                'message' => __('Email Updated successfully.'),
                'url' => route('user.profile'),
            ]);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (AuthException $e) {
            return $this->errorException($e->getCode(), $e->getMessage());
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, __('An error occurred'));
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePassordRequest  $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws \InvalidArgumentException
     * @throws \Exception
     */
    public function updatePassword(UpdatePassordRequest $request)
    {
        try {
            $user = auth()->user();
            // check if the old password is correct
            if (!$user || !Hash::check($request->input('old_password'), $user->password)) {
                throw new AuthException(__('The old password is incorrect'), HttpStatusCode::BAD_REQUEST->value);
            }
            // update password
            $user->update([
                'password' => Hash::make($request->input('new_password'))
            ]);
            // flash success message
            session()->flash('update-password-success-message', __('Updated successfully'));
            // return data
            return $this->returnData(['success' => true, 'message' => __('Updated successfully'), 'url' => route('user.profile')]);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (AuthException $e) {
            return $this->errorException($e->getCode(), $e->getMessage());
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, __('An error occurred'));
        }
    }
}

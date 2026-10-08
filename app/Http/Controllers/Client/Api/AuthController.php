<?php

namespace App\Http\Controllers\Client\Api;

use App\Exceptions\AuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Auth\ForgetRequest;
use App\Http\Requests\Client\Auth\LoginRequest;
use App\Http\Requests\Client\Auth\RegisterRequest;
use App\Http\Requests\Client\Auth\ResetPassordRequest;
use App\Http\Requests\Client\Auth\VerfiyRequest;
use App\Http\Requests\Client\User\UpdatePassordRequest;
use App\Http\Requests\Client\User\UpdatePhotoRequest;
use App\Http\Requests\Client\User\UpdateUserRequest;
use App\Jobs\Client\SendToUserVerifcationMail;
use App\Models\User;
use App\Models\VerificationCode;
use App\Service\Auth\Socialite\AuthGoogleService;
use App\Service\Base\JsonAPIMessages;
use App\Service\Enum\HttpStatusCode;
use App\Service\Enum\VerificationActionType;
use App\Service\Enum\VerificationType;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use JsonAPIMessages;
    /**
     * Generate a strong password
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateStrongPassword()
    {
        try {
            return $this->returnDataWithoutMessage(['password' => passwordGenerator()]);
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, $e->getMessage());
        }
    }
    /**
     * Login user and return a token
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws AuthException
     * @throws HttpResponseException
     * @throws JWTException
     * @throws \Exception
     */
    public function login(LoginRequest $request)
    {
        try {
            $credentials = $request->only('email', 'password');
            // attempt to verify the credentials and create a token for the user
            if (!$token = JWTAuth::attempt($credentials)) {
                throw new AuthException(__('Unauthorized User'), HttpStatusCode::UNAUTHORIZED->value);
            }
            // return the token
            return $this->returnDataWithMessage(__('Login Success'), ['token' => $token], HttpStatusCode::CREATED->value);
        } catch (AuthException $th) {
            return $this->errorException($th->getCode(), $th->getMessage());
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (JWTException $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, __('Could not create token'));
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, __('An error occurred'));
        }
    }
    /**
     * Register a new user
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws HttpResponseException
     * @throws \Exception
     */
    public function register(RegisterRequest $request)
    {
        try {
            $code = (string) random_int(100000, 999999);
            // create user
            $user = (object) runTransaction(function () use ($request, $code) {
                $user = User::create([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'password' => createHash($request->input('password')),
                ]);
                VerificationCode::create([
                    'user_id' => $user->id,
                    'code' => createHash($code),
                    'type' => VerificationType::EMAIL->value,
                    'action_type' => VerificationActionType::REGISTER->value,
                ]);
                return $user;
            });
            // set token of the user
            $token = JWTAuth::fromUser($user);
            // send verification code to user email
            dispatch(new SendToUserVerifcationMail($user->email, __('Activation Code is') . ' ' . $user->verification_code))->delay(now()->addSeconds(5));
            // set array of user data with token
            $userData = ['token' => $token, 'user' => $user];
            // return data
            $message = __('Account Created Successfully Please Verify Your Email');
            // return data
            return $this->returnDataWithMessage($message, $userData, HttpStatusCode::CREATED->value);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, __('An error occurred'));
        }
    }
    /**
     * Verify user email
     *
     * @param VerfiyRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyUser(VerfiyRequest $request)
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
            //
            return $this->returnDataWithMessage(
                'success',
                [
                    'status' => true,
                    'code' => 201,
                    'message' => __('Email verified successfully.')
                ],
                HttpStatusCode::CREATED->value
            );
        } catch (AuthException $e) {
            return $this->errorException($e->getCode(), $e->getMessage());
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, __('An error occurred'));
        }
    }
    /**
     * Get the authenticated user
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthException
     * @throws \Exception
     * @throws TokenExpiredException
     * @throws TokenInvalidException
     * @throws JWTException
     */
    public function user()
    {
        try {
            if (!$user = JWTAuth::parseToken()->authenticate()) {
                throw new AuthException(__('Unauthorized User'), 401);
            }
            //
            // return data
            return $this->returnDataWithoutMessage(['user' => $user], HttpStatusCode::OK->value);
        } catch (TokenExpiredException $e) {
            return $this->errorMessage($e->getMessage());
        } catch (TokenInvalidException $e) {
            return $this->errorMessage($e->getMessage());
        } catch (JWTException $e) {
            return $this->errorMessage($e->getMessage());
        } catch (AuthException $e) {
            return $this->errorException($e->getCode(), $e->getMessage());
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, $e->getMessage());
        }
    }
    /**
     * Logout user (Invalidate the token)
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthException
     * @throws \Exception
     */
    public function logout(Request $request)
    {
        try {
            $token = $request->bearerToken();
            // Invalidate the token
            if ($token) {
                JWTAuth::setToken($token)->invalidate();
                // Return a success response
                return $this->returnDataWithMessage(__('Logout Success'), ['status' => true], 200);
            } else {
                throw new AuthException(__('Authorization Token not found'), HttpStatusCode::UNAUTHORIZED->value);
            }
        } catch (AuthException $e) {
            return $this->errorException($e->getCode(), $e->getMessage());
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, __('An error occurred'));
        }
    }
    /**
     * Forget password
     *
     * @param ForgetRequest $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws AuthException
     * @throws HttpResponseException
     * @throws \Exception
     */
    public function forgetPassword(ForgetRequest $request)
    {
        try {
            $email = $request->input('email');
            // get user by email
            $user = User::where('email', $email)->first();
            // check if user is found
            if (!$user) {
                throw new AuthException(__('User not found'), HttpStatusCode::NOT_FOUND->value);
            }
            $code = (string) random_int(100000, 999999);
            // store verification code in database
            runTransaction(function () use ($code, $email) {
                $verificationCode = VerificationCode::create([
                    'code' => createHash($code),
                    'email' => $email,
                    'type' => VerificationType::EMAIL->value,
                    'action_type' => VerificationActionType::RESET_PASSWORD->value,
                ]);
                // return verification code
                return $verificationCode;
            });
            // dispatch job to send verification code to user email
            dispatch(new SendToUserVerifcationMail($user->email, __('Reset Password Code is') . ' ' . $code))->delay(now()->addSeconds(5));
            // return response
            return $this->returnDataWithMessage(__('Please enter the verification code sent to your email'), ['status' => true], 200);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (AuthException $e) {
            return $this->errorException($e->getCode(), $e->getMessage());
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, __('An error occurred'));
        }
    }
    /**
     * Verify code to reset password
     *
     * @param VerfiyRequest $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws AuthException
     * @throws HttpResponseException
     * @throws \Exception
     */
    public function verfiyCodeToResetPassword(VerfiyRequest $request)
    {
        try {
            // check if header is not found
            if (!$request->hasHeader('x-verification-email')) {
                throw new AuthException(__('Email is required'), HttpStatusCode::PRECONDITION_FAILED->value);
            }
            // get header
            $header = $request->header('x-verification-email');
            // get verification code
            $vercificationCode = VerificationCode::where('email', $header)
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
            // return success response
            return $this->returnDataWithMessage(__('Email verified successfully.'), [
                'status' => true,
                'message' => __('Email verified successfully.')
            ], HttpStatusCode::CREATED->value);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (AuthException $e) {
            return $this->errorException($e->getCode(), $e->getMessage());
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, __('An error occurred'));
        }
    }
    /**
     * Reset password
     *
     * @param ResetPassordRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws AuthException
     * @throws \Exception
     */
    public function resetPassword(ResetPassordRequest $request)
    {
        try {
            // check if header is not found
            if (!$request->hasHeader('x-verification-email')) {
                throw new AuthException(__('Email is required'), HttpStatusCode::PRECONDITION_FAILED->value);
            }
            // get header
            $header = $request->header('x-verification-email');
            // get new password
            $newPassword = $request->input('password');
            // get user by email
            $user = User::where('email', $header)->first();
            // check if user is found
            if (!$user) {
                throw new AuthException(__('User not found'), HttpStatusCode::NOT_FOUND->value);
            }
            // update user password
            $user->update(['password' => createHash($newPassword)]);
            // return success response
            return $this->returnDataWithMessage(__('Password reset successfully.'), [
                'status' => true,
                'message' => __('Password reset successfully.')
            ], HttpStatusCode::CREATED->value);
        } catch (AuthException $e) {
            return $this->errorException($e->getCode(), $e->getMessage());
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, __('An error occurred'));
        }
    }
    /**
     * Update user profile
     *
     * @param UpdateUserRequest $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws HttpResponseException
     * @throws \Exception
     */
    public function updateProfile(UpdateUserRequest $request)
    {
        try {
            $user = auth()->guard('api')->user();
            // update user
            $user->update($request->all());
            // return success response
            return $this->returnDataWithMessage(__('Profile updated successfully.'), [
                'status' => true,
                'message' => __('Profile updated successfully.')
            ], HttpStatusCode::CREATED->value);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, __('An error occurred'));
        }
    }
    /**
     * Update user photo profile
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws HttpResponseException
     * @throws \Exception
     */
    public function updatePhotoProfile(UpdatePhotoRequest $request)
    {
        try {
            $user = auth()->guard('api')->user();
            // upload photo
            $photoPath = UploadWithOutStorage('client/img/', $request->file('photo'));
            // update user photo
            $user->update(['photo' => $photoPath]);
            // return success response
            return $this->returnDataWithMessage(__('Profile photo updated successfully.'), [
                'status' => true,
                'message' => __('Profile photo updated successfully.')
            ], HttpStatusCode::CREATED->value);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, __('An error occurred'));
        }
    }
    /**
     * Update user password
     *
     * @param UpdatePassordRequest $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws HttpResponseException
     * @throws \Exception
     */
    public function updatePassword(UpdatePassordRequest $request)
    {
        try {
            $user = auth()->guard('api')->user();
            // check if the old password is correct
            if (!$user || !Hash::check($request->input('old_password'), $user->password)) {
                throw new AuthException(__('The old password is incorrect'), HttpStatusCode::PRECONDITION_FAILED->value);
            }
            // update user password
            $user->update(['password' => createHash($request->input('new_password'))]);
            // return success response
            return $this->returnDataWithMessage(__('Password updated successfully.'), [
                'status' => true,
                'message' => __('Password updated successfully.')
            ], 201);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (AuthException $e) {
            return $this->errorException($e->getCode(), $e->getMessage());
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, __('An error occurred'));
        }
    }
    /**
     * Google auth
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws HttpResponseException
     * @throws AuthException
     * @throws \Exception
     */
    public function googleAuth(Request $request)
    {
        try {
            $idToken = $request->input('id_token');
            // check if id token is not found
            if (empty($idToken)) {
                throw new AuthException(__('Id token is required'), HttpStatusCode::PRECONDITION_FAILED->value);
            }
            // get user info
            $googleUser = new AuthGoogleService()->authInfo($idToken);
            // create or update user
            $user = (object) runTransaction(function () use ($googleUser) {
                $user = User::updateOrCreate(
                    [
                        'email' => $googleUser['email'],
                    ],
                    [
                        'name' => $googleUser['name'],
                        'google_id' => $googleUser['sub'],
                    ]
                );
                return $user;
            });
            // set token of the user
            $token = JWTAuth::fromUser($user);
            // set array of user data with token
            $userData = ['token' => $token, 'user' => $user];
            // return data
            $message = __('Login Success');
            // return data
            return $this->returnDataWithMessage($message, $userData, HttpStatusCode::CREATED->value);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (AuthException $e) {
            return $this->errorException($e->getCode(), $e->getMessage());
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, __('An error occurred'));
        }
    }
}

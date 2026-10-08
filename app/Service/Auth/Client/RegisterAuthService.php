<?php

namespace App\Service\Auth\Client;

use App\Jobs\Client\SendToUserVerifcationMail;
use App\Models\User;
use App\Models\VerificationCode;
use App\Service\Auth\RegisterAuthService as BaseRegisterAuthService;
use App\Service\Enum\HttpStatusCode;
use App\Service\Enum\VerificationActionType;
use App\Service\Enum\VerificationType;
use Illuminate\Http\Request;

class RegisterAuthService extends BaseRegisterAuthService
{
    /**
     * The verification code
     *
     * @var string
     */
    protected string $verificationCode {
        set {
            if (empty($value)) {
                throw new \InvalidArgumentException('Verification code is required', HttpStatusCode::UNPROCESSABLE_CONTENT->value);
            }
            $this->verificationCode = $value;
        }
        get {
            return $this->verificationCode;
        }
    }
    /**
     * The email
     *
     * @var string
     */
    protected string $email {
        set {
            if (empty($value)) {
                throw new \InvalidArgumentException('Email is required', HttpStatusCode::UNPROCESSABLE_CONTENT->value);
            }
            $this->email = $value;
        }
        get {
            return $this->email;
        }
    }
    /**
     * The timer
     *
     * @var string
     */
    protected string $timer {
        set {
            if (empty($value)) {
                throw new \InvalidArgumentException('Timer is required', HttpStatusCode::UNPROCESSABLE_CONTENT->value);
            }
            $this->timer = $value;
        }
        get {
            return $this->timer;
        }
    }
    /**
     * create new user and authenticate it
     *
     * @param Request $request
     * @return object
     */
    protected function create(Request $request)
    {
        $code = (string) random_int(100000, 999999);
        // create user
        $create = (object) runTransaction(function () use ($request, $code) {
            $create = User::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => createHash($request->input('password')),
            ]);
            $createverficationCode = VerificationCode::create([
                'user_id' => $create->id,
                'code' => createHash($code),
                'type' => VerificationType::EMAIL->value,
                'action_type' => VerificationActionType::REGISTER->value,
            ]);
            // set email
            $this->email = $create->email;
            // set verification code
            $this->verificationCode = $code;
            // set timer
            $this->timer = $createverficationCode->expires_at->toISOString();
            // return user
            return $create;
        });
        // put verification code and timer in session
        session()->put('verification-timer', $this->timer);
        // send verification code to user email
        dispatch(new SendToUserVerifcationMail($this->email, __('Activation Code is') . ' ' . $this->verificationCode))->delay(now()->addSeconds(5));
        // return user
        return $create;
    }
    /**
     * override Get the redirection to be used during authentication.
     *
     * @return string
     */
    protected function getRedirection()
    {
        if (session()->has('url.intended')) {
            return lastUrl();
        }
        return route('index-page', ['is_verify' => 0]);
    }
}

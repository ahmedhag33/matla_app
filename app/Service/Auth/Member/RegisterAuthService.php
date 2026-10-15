<?php

namespace App\Service\Auth\Member;

use App\Jobs\Member\SendToMemberVerifcationMail;
use App\Models\Member;
use App\Models\MemberVerficationCodes;
use App\Models\WorkspaceRoles;
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
     * show Register Form if the user is not authenticated
     *
     * @return \Illuminate\View\View
     */
    public function showRegisterForm()
    {
        $roles = WorkspaceRoles::highest()->select('id', 'name', 'slug')->get();
        // return view
        return view('membership.auth.register', compact('roles'));
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
            $create = Member::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'workspace_role' => $request->input('role_id'),
                'password' => createHash($request->input('password')),
            ]);
            $createverficationCode = MemberVerficationCodes::create([
                'member_id' => $create->id,
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
        dispatch(new SendToMemberVerifcationMail($this->email, $this->verificationCode))->delay(now()->addSeconds(5));
        // return user
        return $create;
    }
}

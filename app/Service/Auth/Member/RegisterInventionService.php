<?php

namespace App\Service\Auth\Member;

use App\Jobs\Workspace\MemberVerficationJob;
use App\Models\Member;
use App\Models\MemberVerficationCodes;
use App\Service\Auth\RegisterAuthService;
use App\Service\Enum\HttpStatusCode;
use App\Service\Enum\VerificationActionType;
use App\Service\Enum\VerificationType;
use Illuminate\Http\Request;

class RegisterInventionService extends RegisterAuthService
{
    /**
     * The guard name for admin authentication.
     *
     * @var string
     */
    protected $guardname = 'member';
    /**
     * The token for the invention invitation.
     *
     * @var string
     */
    protected string $token {
        set {
            if (empty($value)) {
                throw new \InvalidArgumentException('Token cannot be empty.', HttpStatusCode::BAD_REQUEST->value);
            }
            $this->token = $value;
        }
        get {
            return $this->token;
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
        // Set the token for the invention invitation
        $this->token = createToken(10);
        // Run the transaction to create the member and verification code
        $create = (object) runTransaction(function () use ($request) {
            $create = (object) Member::create([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'workspace_role_id' => $request->input('role_id'),
                'password' => createHash($request->input('password')),
            ]);
            MemberVerficationCodes::create([
                'member_id' => $create->id,
                'code' => hash('sha256', $this->token),
                'type' => VerificationType::EMAIL->value,
                'action_type' => VerificationActionType::REGISTER->value,
            ]);
            // return user
            return $create;
        });
        // send verification code to user email
        dispatch(new MemberVerficationJob($create->email, $create->name, route('workspace.auth.verify-done', ['token' => $this->token])))->delay(now()->addSeconds(5));
        // Return the created member object
        return $create;
    }
    /**
     * Get the redirection to be used during authentication.
     *
     * @return string
     */
    protected function getRedirection()
    {
        return route('workspace.auth.invention-verify', ['token' => $this->token]);
    }
}

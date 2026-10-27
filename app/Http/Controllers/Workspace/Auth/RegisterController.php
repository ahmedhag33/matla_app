<?php

namespace App\Http\Controllers\Workspace\Auth;

use App\Exceptions\AuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Workspace\RegisterRequest;
use App\Models\WorkspaceInvitations;
use App\Service\Auth\Member\RegisterAuthService;
use App\Service\Base\JsonAPIMessages;
use App\Service\Enum\HttpStatusCode;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterController extends Controller
{
    use JsonAPIMessages;
    /**
     * var RegisterAuthService
     *
     * @var RegisterAuthService */
    protected ?RegisterAuthService $registerService;
    /**
     * Create a new controller instance.
     *
     * @param RegisterAuthService $registerService
     */
    public function __construct(RegisterAuthService $registerService)
    {
        $this->registerService = $registerService;
    }
    /**
     * Show the application's register form.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return $this->registerService->showRegisterForm();
    }
    /**
     * Show the register form for an invention invitation.
     *
     * @param string $token
     * @return \Illuminate\View\View
     */
    public function inventionRegisterForm($token)
    {
        $invention = WorkspaceInvitations::with(['role', 'workspace'])->where('token', hash('sha256', $token))->first();
        // Check if the invitation exists
        if (!$invention) {
            abort(404);
        }
        // Check if the invitation has expired
        if (now()->greaterThanOrEqualTo($invention->expires_at)) {
            abort(403);
        }
        // Pass the invitation data to the view
        return view('membership.auth.register_invention', ['invention' => $invention]);
    }
    /**
     * Create a new user instance after a valid registration.
     *
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws AuthException
     * @throws HttpResponseException
     * @throws \Exception
     */
    public function register(RegisterRequest $request)
    {
        try {
            return $this->registerService->register($request);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (AuthException $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, $e->getMessage());
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, $e->getMessage());
        }
    }
}

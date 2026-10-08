<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Exceptions\AuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LoginRequest;
use App\Service\Auth\Admin\LoginAuthService;
use App\Service\Base\JsonAPIMessages;
use App\Service\Enum\HttpStatusCode;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginController extends Controller
{
    use JsonAPIMessages;
    /**
     * The login service instance.
     *
     * @var LoginAuthService|null
     */
    protected ?LoginAuthService $loginService;
    /**
     * Create a new controller instance.
     *
     * @param LoginAuthService $loginService
     */
    public function __construct(LoginAuthService $loginService)
    {
        $this->loginService = $loginService;
    }
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return $this->loginService->loginPage();
    }
    /**
     * login user to the system
     *
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws AuthException
     * @throws HttpResponseException
     * @throws \Exception
     */
    public function login(LoginRequest $request)
    {
        try {
            return $this->loginService->login($request);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (AuthException $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, $e->getMessage());
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, __('An error occurred'));
        }
    }
    /**
     * logout user from the system
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        return $this->loginService->logout();
    }
}

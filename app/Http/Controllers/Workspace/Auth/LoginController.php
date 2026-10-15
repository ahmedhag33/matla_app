<?php

namespace App\Http\Controllers\Workspace\Auth;

use App\Http\Controllers\Controller;
use App\Service\Auth\Member\LoginAuthService;
use App\Service\Base\JsonAPIMessages;

class LoginController extends Controller
{
    use JsonAPIMessages;
    /**
     * The login service
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
    public function index()
    {
        return $this->loginService->loginPage();
    }
}

<?php

namespace App\Http\Controllers\Workspace;

use App\Http\Controllers\Controller;
use App\Service\Auth\Member\LoginAuthService;
use App\Service\Base\JsonAPIMessages;

class MemberController extends Controller
{
    use JsonAPIMessages;
    /**
     * var LoginAuthService
     *
     * @var LoginAuthService */
    protected ?LoginAuthService $loginAuthService;
    /**
     * Create a new controller instance.
     *
     * @param LoginAuthService $loginAuthService
     */
    public function __construct(LoginAuthService $loginAuthService)
    {
        $this->loginAuthService = $loginAuthService;
    }
    /**
     *  Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('membership.index');
    }
    /**
     * logout user from the system
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        return $this->loginAuthService->logout();
    }
}

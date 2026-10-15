<?php

namespace App\Http\Controllers\Workspace\Auth;

use App\Http\Controllers\Controller;
use App\Service\Auth\Member\RegisterAuthService;
use App\Service\Base\JsonAPIMessages;

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
}

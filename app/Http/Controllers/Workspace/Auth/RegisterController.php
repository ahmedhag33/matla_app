<?php

namespace App\Http\Controllers\Workspace\Auth;

use App\Exceptions\AuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Workspace\RegisterRequest;
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

<?php

namespace App\Http\Controllers\Client\Auth;

use App\Exceptions\AuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Client\Auth\RegisterRequest;
use App\Service\Auth\Client\RegisterAuthService;
use App\Service\Base\JsonAPIMessages;
use App\Service\Enum\HttpStatusCode;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterController extends Controller
{
    use JsonAPIMessages;
    /**
     * The RegisterAuthService instance.
     *
     * @var RegisterAuthService|null
     */
    protected ?RegisterAuthService $registerService;
    /**
     * Create a new controller instance.
     *
     * @param RegisterAuthService $registerService
     *
     * @return void
     */
    public function __construct(RegisterAuthService $registerService)
    {
        $this->registerService = $registerService;
    }
    /**
     * Show the registration form.
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
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, __('An error occurred'));
        }
    }
}

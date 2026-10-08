<?php

namespace App\Service\Auth;

use App\Exceptions\AuthException;
use App\Service\Base\JsonAPIMessages;
use App\Service\Enum\HttpStatusCode;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

abstract class RegisterAuthService
{
    use BaseAuthicate, JsonAPIMessages;
    /**
     * show Register Form if the user is not authenticated
     *
     * @return \Illuminate\View\View
     */
    public function showRegisterForm()
    {
        return view($this->getView());
    }
    /**
     * create new user and authenticate it
     *
     * @param Request $request
     * @return object
     */
    abstract protected function create(Request $request);
    /**
     * register new user and authenticate it
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \InvalidArgumentException
     */
    public function register(Request $request)
    {
        $user = $this->create($request);
        // check if the user created successfully
        if (!$user) {
            throw new AuthException(__('Error Creating User'), HttpStatusCode::UNPROCESSABLE_CONTENT->value);
        }
        // fire Registered event
        event(new Registered($user));
        // authenticate the user
        $this->guard()->login($user);
        // flash success message to session
        session()->flash('register-success', __('Account created successfully'));
        // send success message
        $data = ['message' => __('Account created successfully'), 'url' => $this->getRedirection()];
        // return data
        return $this->returnData($data, HttpStatusCode::CREATED->value);
    }
}

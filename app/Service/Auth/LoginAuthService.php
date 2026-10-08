<?php

namespace App\Service\Auth;

use App\Exceptions\AuthException;
use App\Service\Base\JsonAPIMessages;
use App\Service\Enum\HttpStatusCode;
use Illuminate\Http\Request;

abstract class LoginAuthService
{
    use BaseAuthicate, JsonAPIMessages;
    /**
     * show Login Form if the user is not authenticated
     *
     * @return \Illuminate\View\View
     */
    public function loginPage()
    {
        return view($this->getView());
    }
    /**
     * authenticate user and login
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \InvalidArgumentException
     */
    public function login(Request $request)
    {
        if ($this->guard()->attempt($request->only($this->getUsername(), 'password'))) {
            // return response to client
            $data = ['message' => __('Login Success'), 'url' => $this->getRedirection()];
            // put login success message in session
            session()->flash('login-success', __('Login Success'));
            // return data to the user
            return $this->returnData($data,HttpStatusCode::CREATED->value);
        } else {
            throw new AuthException(__('Login Failed'), HttpStatusCode::UNAUTHORIZED->value);
        }
    }
    /**
     * Show the application logout.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        $this->guard()->logout();
        // flush the session
        session()->flush();
        // put logout success message in session
        session()->put('logout-success', __('Logout Success'));
        // redirect to the logout redirection
        return redirect($this->getLogoutRedirection());
    }
}

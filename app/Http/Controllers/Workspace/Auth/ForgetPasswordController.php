<?php

namespace App\Http\Controllers\Workspace\Auth;

use App\Http\Controllers\Controller;
use App\Service\Base\JsonAPIMessages;

class ForgetPasswordController extends Controller
{
    use JsonAPIMessages;
    /**
     * Show forget password page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function forgetPage()
    {
        return view('membership.auth.forget');
    }
    /**
     * Show verify password page
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function verifyPage()
    {
        return view('membership.auth.verify-password');
    }
}

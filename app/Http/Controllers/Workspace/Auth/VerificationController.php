<?php

namespace App\Http\Controllers\Workspace\Auth;

use App\Http\Controllers\Controller;
use App\Service\Base\JsonAPIMessages;

class VerificationController extends Controller
{
    use JsonAPIMessages;
    /**
     * Create View for verification
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('membership.auth.verfiy');
    }
}

<?php

namespace App\Http\Controllers\Workspace;

use App\Http\Controllers\Controller;
use App\Service\Base\JsonAPIMessages;

class MemberController extends Controller
{
    use JsonAPIMessages;
    /**
     *  Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('membership.index');
    }
}

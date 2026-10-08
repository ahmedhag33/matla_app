<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Service\Base\JsonAPIMessages;

class UsersController extends Controller
{
    use JsonAPIMessages;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = Admin::get();
        // get view with users
        return view('dashboard.users.index', compact('users'));
    }
}

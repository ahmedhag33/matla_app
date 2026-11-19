<?php

namespace App\Http\Controllers\Workspace;

use App\Http\Controllers\Controller;
use App\Service\Base\JsonAPIMessages;

class TasksController extends Controller
{
    use JsonAPIMessages;
    /**
     * Display a listing of the tasks.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('workspace.tasksManagment.tasks.index');
    }
}

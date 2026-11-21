<?php

namespace App\Http\Controllers\Workspace;

use App\Http\Controllers\Controller;
use App\Models\Program;
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
        $programs = Program::get();
        // Retrieve all programs to populate the program select dropdown in the view.
        return view('workspace.tasksManagment.tasks.index', compact('programs'));
    }
}

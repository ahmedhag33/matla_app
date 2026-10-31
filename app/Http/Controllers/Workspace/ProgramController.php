<?php

namespace App\Http\Controllers\Workspace;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProgramTypes;
use App\Service\Base\JsonAPIMessages;

class ProgramController extends Controller
{
    use JsonAPIMessages;
    /**
     * Display the program index page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $programs = Program::with(['type','createdBy','presenters','broadcastDays'])->get();
        // Retrieve all program types.
        $programsTypes = ProgramTypes::all();
        // Retrieve all programs with their related type, creator, presenters, and broadcast days.
        return view('workspace.program.index', compact('programs', 'programsTypes'));
    }
}

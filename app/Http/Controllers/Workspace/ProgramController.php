<?php

namespace App\Http\Controllers\Workspace;

use App\Http\Controllers\Controller;
use App\Http\Requests\Workspace\ProgramStepRequest;
use App\Models\Member;
use App\Models\Program;
use App\Models\ProgramTypes;
use App\Service\Base\JsonAPIMessages;
use App\Service\Enum\HttpStatusCode;
use Illuminate\Http\Exceptions\HttpResponseException;

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
        $programs = Program::with(['type', 'createdBy', 'presenters', 'broadcastDays'])->get();
        // Retrieve all program types.
        $programsTypes = ProgramTypes::all();
        // Retrieve all members with the role of presenter in the current workspace.
        $presenters = Member::inWorkspace()->equalRole('presenter')->get();
        // Retrieve all programs with their related type, creator, presenters, and broadcast days.
        return view('workspace.program.index', compact('programs', 'programsTypes', 'presenters'));
    }
    /**
     * Handle the program step request.
     *
     * @param  ProgramStepRequest  $request
     * @param  int  $step
     * @return \Illuminate\Http\JsonResponse|string
     */
    public function step(ProgramStepRequest $request, $step)
    {
        try {
            return $this->returnData(['step' => $step, 'data' => $request->validated()]);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, __('An unexpected error occurred.'));
        }
    }
}

<?php

namespace App\Http\Controllers\Workspace;

use App\Http\Controllers\Controller;
use App\Service\Base\JsonAPIMessages;
use App\Service\Enum\HttpStatusCode;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use JsonAPIMessages;
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('workspace.dashboard.index');
    }
    /**
     * Mark a notification as read.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function readNotification(Request $request)
    {
        try {
            $notification = auth()->guard('member')->user()->notification()->find($request->input('id'));
            // Mark the notification as read if it exists
            $notification->update(['read_at' => now()]);
            // Return a success response regardless of whether the notification existed or not
            return $this->returnData(['status' => 'success']);
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, $e->getMessage());
        }
    }
}

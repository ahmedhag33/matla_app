<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Exceptions\AuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\RecoverPasswordRequest;
use App\Service\Base\JsonAPIMessages;
use App\Service\Enum\HttpStatusCode;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;

class RecoverPasswordController extends Controller
{
    use JsonAPIMessages;
    /**
     * Display the recover password page.
     *
     * @return \Illuminate\View\View
     */
    public function recoverPasswordPage()
    {
        return view('dashboard.auth.recover-password');
    }
    /**
     * recover password
     *
     * @param RecoverPasswordRequest $request
     * @return \Illuminate\Http\JsonResponse|string
     * @throws AuthException
     * @throws HttpResponseException
     * @throws \Exception
     */
    public function recoverPassword(RecoverPasswordRequest $request)
    {
        try {
            $user = auth()->guard('admin')->user();
            // check if the old password is correct
            if (!$user || !Hash::check($request->input('old_password'), $user->password)) {
                throw new AuthException(__('The old password is incorrect'), HttpStatusCode::BAD_REQUEST->value);
            }
            // update password
            $user->update([
                'password' => createHash($request->input('new_password')),
                'must_change_password' => 1
            ]);
            // flash success message
            session()->flash('update-password-success-message', __('Updated successfully'));
            // return data
            return $this->returnData(['success' => true, 'message' => __('Password updated successfully.'), 'url' => route('dashboard.index')]);
        } catch (HttpResponseException $e) {
            return $e->getResponse();
        } catch (AuthException $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, $e->getMessage());
        } catch (\Exception $e) {
            return $this->errorException(HttpStatusCode::INTERNAL_SERVER_ERROR->value, __('An error occurred'));
        }
    }
}

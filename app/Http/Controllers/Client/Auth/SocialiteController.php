<?php

namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Service\Base\JsonAPIMessages;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class SocialiteController extends Controller
{
    use JsonAPIMessages;
     /**
     * Redirect the user to the OAuth Provider.
     *
     * @param Request $request
     * @param string $provider
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function redirectToProvider(Request $request, $provider)
    {
        $this->validateProvider($request);
        // get the provider's authorization page url and redirect the user to it.
        return Socialite::driver($provider)->redirect();
    }
    /**
     * Obtain the user information from the provider and log the user in.
     *
     * @param Request $request
     * @param string $provider
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback(Request $request, string $provider)
    {
        $this->validateProvider($request);
        // get the provider's user information and return it.
        $response = Socialite::driver($provider)->stateless()->user();
        // store the user information in the session or database and log the user in.
        $arr = ['email' => $response->getEmail(), 'name' => $response->getName() ?? $response->getNickname()];
        // if the user already exists, log them in, otherwise create a new user and log them in.
        $user = User::firstOrCreate($arr);
        // update the user's provider id and name if they were recently created.
        $data = [$provider . '_id' => $response->getId()];
        // if the user was recently created, set their name to the provider's name or nickname and fire the Registered event.
        if ($user->wasRecentlyCreated) {
            $data['name'] = $response->getName() ?? $response->getNickname();
            // fire the Registered event for the newly created user.
            event(new Registered($user));
        }
        $user->update($data);
        // log the user in and redirect them to the intended page.
        auth()->guard()->login($user, true);
        // flash a success message to the session and redirect the user to the intended page.
        session()->flash('login-success', __('Login Success'));
        // redirect the user to the intended page or the index page if there is no intended page.
        if (session()->has('url.intended')) {
            return redirect(session()->pull('url.intended'));
        } else {
            return redirect(route('index-page'));
        }
    }
    /**
     * Validate the provider.
     *
     * @return \Illuminate\Http\RedirectResponse|array
     */
    protected function validateProvider(Request $request)
    {
        return $this->getValidationFactory()->make(
            $request->route()->parameters(),
            ['provider' => 'in:facebook,google']
        )->validate();
    }
}

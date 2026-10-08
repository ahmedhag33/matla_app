<?php

namespace App\Service\Auth\Socialite;

use App\Exceptions\AuthException;
use App\Service\Auth\Enum\Google;
use App\Service\Base\ApiIntegration;

class AuthGoogleService
{
    use ApiIntegration;
    /**
     * get user info from google api
     *
     * @param $id_token
     * @return array
     */
    public function authInfo($id_token)
    {
        // get user info from google api
        $googleUser = $this->getRequest(Google::URL->value . '/' . Google::TOKEN_INFO->value, [
            Google::ID_TOKEN->value => $id_token,
        ]);
        // check if the audience is the same as the client id
        if ($googleUser['aud'] != config('services.google.client_id')) {
            throw new AuthException(__('Unauthorized User'), 401);
        }
        // check if the email is verified
        if (($googleUser['email_verified'] == 'false')) {
            throw new AuthException(__('Email is not active'), 401);
        }
        return $googleUser;
    }
}

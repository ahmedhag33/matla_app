<?php

namespace App\Service\Auth\Client;

use App\Service\Auth\LoginAuthService as BaseLoginAuthService;

class LoginAuthService extends BaseLoginAuthService
{
    /**
     * The redirection path after login
     *
     * @var string
     */
    protected $redirection = 'index-page';
    /**
     * The redirection path after logout
     *
     * @var string
     */
    protected $logoutRedirection = 'index-page';
    /**
     *  get Redirection of the class instance
     * @return mixed
     */
    protected function getRedirection()
    {
        if (session()->has('url.intended')) {
            return session()->pull('url.intended');
        }
        return parent::getRedirection();
    }
}

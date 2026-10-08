<?php

namespace App\Service\Auth\Admin;

use App\Service\Auth\LoginAuthService as BaseLoginAuthService;

class LoginAuthService extends BaseLoginAuthService
{
    /**
     * The guard name for admin authentication.
     *
     * @var string
     */
    protected $guardname = 'admin';
    /**
     * The view name for admin login.
     *
     * @var string
     */
    protected $viewname = 'dashboard.auth.login';
   /**
     * The redirection name for admin login.
     *
     * @var string
     */
    protected $redirection = 'dashboard.index';
    /**
     * The logout redirection name for admin login.
     *
     * @var string
     */
    protected $logoutRedirection = 'dashboard.auth.login';
}

<?php

namespace App\Service\Auth\Member;

use App\Service\Auth\LoginAuthService as BaseLoginAuthService;

class LoginAuthService extends BaseLoginAuthService
{
    /**
     * The guard name for admin authentication.
     *
     * @var string
     */
    protected $guardname = 'member';
    // show Login Form if the user is not authenticated
    protected $viewname = 'membership.auth.login';
    /**
     * The redirection path after login
     *
     * @var string
     */
    protected $redirection = 'workspace.member.index';
    /**
     * The redirection path after logout
     *
     * @var string
     */
    protected $logoutRedirection = 'workspace.auth.login';
}

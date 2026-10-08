<?php

namespace App\Service\Auth;

use App\Service\Enum\HttpStatusCode;

trait BaseAuthicate
{
    /**
     * Get the guard to be used during authentication.
     *
     * @return string
     */
    protected function getGuardName()
    {
        return property_exists($this, 'guardname') ? $this->guardname : null;
    }
    /**
     * Get the view to be used during authentication.
     *
     * @return string
     */
    protected function getView()
    {
        return property_exists($this, 'viewname') ? $this->viewname : HttpStatusCode::NOT_FOUND->value;
    }
    /**
     * Get the guard to be used during authentication.
     *
     * @return object
     */
    protected function guard()
    {
        return (is_null($this->getGuardName())) ? auth()->guard() : auth()->guard($this->getGuardName());
    }
    /**
     * Get the username to be used during authentication.
     *
     * @return string
     */
    protected function getUsername()
    {
        return property_exists($this, 'username') ? $this->username : 'email';
    }
    /**
     * Get the redirection to be used during authentication.
     *
     * @return string
     */
    protected function getRedirection()
    {
        return route(property_exists($this, 'redirection') ? $this->redirection : 'page-404');
    }
    /**
     * Get the logout redirection to be used during authentication.
     *
     * @return string
     */
    protected function getLogoutRedirection()
    {
        return route(property_exists($this, 'logoutRedirection') ? $this->logoutRedirection : 'page-404');
    }
}

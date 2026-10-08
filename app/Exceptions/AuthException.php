<?php

namespace App\Exceptions;

use App\Service\Base\JsonAPIMessages;
use Exception;

class AuthException extends Exception
{
    use JsonAPIMessages;
    /**
     * Render the exception as an HTTP response.

     * @return \Illuminate\Http\JsonResponse
     */
    public function render()
    {
        return $this->errorException($this->getCode(), $this->getMessage());
    }
}

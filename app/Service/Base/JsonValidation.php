<?php

namespace App\Service\Base;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

trait JsonValidation
{
    use JsonAPIMessages;
    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = [];
        // loop through the errors and format them as needed
        foreach ($validator->errors()->toArray() as $field => $messages) {
            $errors[] = [
                'field' => $field,
                'messages' => $messages[0],
            ];
        }
        // throw an HttpResponseException with the formatted errors
        throw new HttpResponseException($this->errorException(422, [$errors]));
    }
}

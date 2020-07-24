<?php

namespace App\Util;

class ValidationErrors
{
    /**
     * Transform an iterable of validation errors into something that humans can understand
     * @param array $errors
     * @return array
     */
    function list($errors)
    {
        $errorList = [];

        foreach ($errors as $error) {
            $path = $error->getPropertyPath();
            $message = $error->getMessage();

            $errorList[$path] = $message;
        }

        return $errorList;
    }
}

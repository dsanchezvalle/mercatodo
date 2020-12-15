<?php

namespace App\Exceptions;

use Throwable;

class ImportValidationException extends \Exception
{
    private $errors;

    public function __construct($errors, $code = 0, Throwable $previous = null)
    {
        $this->errors = $errors;
        parent::__construct('Import has validation errors', $code, $previous);
    }

    public function errors()
    {
        return $this->errors;
    }
}

<?php

namespace App\Exceptions\Auth;

use Exception;

class EmailNotVerifiedException extends Exception
{
    public function __construct()
    {
        parent::__construct('Your email address is not verified.');
    }
}

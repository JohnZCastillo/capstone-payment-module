<?php

namespace John\PaymentModule\exception;

use Exception;

class UserAlreadyPaidException extends Exception
{

    public function __construct()
    {
        parent::__construct("User Already Paid");
    }
}
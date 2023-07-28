<?php

namespace John\PaymentModule\exception;


use Exception;


/**
 * Custom exception class for indicating insufficient amount.
 */
class InsufficientAmountException extends Exception
{
    public function __construct()
    {
        parent::__construct("Insufficient Amount");
    }
}
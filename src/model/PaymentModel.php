<?php

namespace John\PaymentModule\model;

/**
 * The PaymentModel interface represents a payment entity and defines methods to access its properties.
 */
interface PaymentModel {

    /**
     * Get the payment amount.
     *
     * @return float The payment amount.
     */
    public function getAmount(): float;

    /**
     * Get the date from which the payment is due.
     *
     * @return string The date in the format 'YYYY-MM-DD'.
     */
    public function getFromDue(): string;

    /**
     * Get the date until which the payment is due.
     *
     * @return string The date in the format 'YYYY-MM-DD'.
     */
    public function getToDue(): string;
}
<?php

namespace John\PaymentModule\model;

/**
 * The PaymentDue interface defines methods to manage payment dues.
 */
interface PaymentDue {

    /**
     * Get the total due amount for a specified date range.
     *
     * This method calculates the total due amount for the provided date range
     * by summing up the dues for each month within the specified range.
     *
     * @param string $from The start date of the date range in the format 'YYYY-MM-DD'.
     * @param string $to The end date of the date range in the format 'YYYY-MM-DD'.
     * @return float The total due amount for the specified date range.
     */
    public function getDueFor($from, $to): float;

    /**
     * Get the initial payment date.
     *
     * This method retrieves the initial payment date for the dues calculation.
     * The initial payment date can be used as the starting point for calculating dues.
     *
     * @return string The initial payment date in the format 'YYYY-MM-DD'.
     */
    public function getInitialPaymentDate(): string;
}

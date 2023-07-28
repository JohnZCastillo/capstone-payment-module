<?php

namespace John\PaymentModule;

use DateTime;

/**
 * The TimeHelper class provides utility methods for handling dates and times.
 */
class TimeHelper {

    /**
     * Get the first day of the current month in the 'Y-m-01' format.
     *
     * @return string The first day of the current month in the 'Y-m-01' format.
     */
    private static function getCurrentMonth() {
        return date("Y-m-01");
    }

    /**
     * Get an array of months between the given start month and end month (inclusive).
     *
     * If the end month is not provided, it defaults to the current month.
     *
     * @param string $startMonth The start month in the 'Y-m' format (e.g., '2023-07').
     * @param string|null $endMonth The end month in the 'Y-m' format (e.g., '2023-12'). Defaults to the current month if not provided.
     * @return array An array of months between the start and end months (inclusive) in the 'Y-m-01' format.
     */
    public static function getMonths($startMonth, $endMonth = null) {

        if ($endMonth == null) {
            $endMonth = TimeHelper::getCurrentMonth();
        }

        // Create DateTime objects for the start and end months
        $startDateTime = DateTime::createFromFormat('Y-m', $startMonth)->modify('first day of this month');
        $endDateTime = DateTime::createFromFormat('Y-m', $endMonth)->modify('first day of this month');

        // Initialize an empty array to store the months
        $months = [];

        // Loop through the months and add them to the array
        while ($startDateTime <= $endDateTime) {
            $months[] = $startDateTime->format('Y-m-01');
            $startDateTime->modify('+1 month'); // Add 1 month
        }

        return $months;
    }
}

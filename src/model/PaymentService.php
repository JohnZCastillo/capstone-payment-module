<?php

namespace John\PaymentModule\model;

/**
 * The PaymentService interface defines methods to manage payments and dues.
 */
interface PaymentService {

    /**
     * Process the payment.
     *
     * @param PaymentModel $paymentModel The payment model representing the payment to be processed.
     * @return void
     */
    public function pay(PaymentModel $paymentModel);

    /**
     * Check if the current payment is paid for a specific month.
     *
     * @param int $month The month for which the payment status should be checked (1 to 12).
     * @return bool True if the payment is paid for the specified month, false otherwise.
     */
    public function isPaid($from,$to): bool;
}
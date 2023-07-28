<?php

namespace John\PaymentModule;

use John\PaymentModule\exception\InsufficientAmountException;
use John\PaymentModule\exception\UserAlreadyPaidException;
use John\PaymentModule\model\PaymentDue;
use John\PaymentModule\model\PaymentModel;
use John\PaymentModule\model\PaymentService;
use John\PaymentModule\model\UserModel;

/**
 * The PaymentManager class handles payment processing and due management.
 */
class PaymentManager {

    /**
     * @var PaymentService $paymentService The service responsible for processing payments.
     */
    private PaymentService $paymentService;

    /**
     * @var PaymentDue $paymentDue The service responsible for managing payment dues.
     */
    private PaymentDue $paymentDue;

    /**
     * Constructor to initialize PaymentManager with PaymentService and PaymentDue.
     *
     * @param PaymentService $paymentService The service responsible for processing payments.
     * @param PaymentDue $paymentDue The service responsible for managing payment dues.
     */
    public function __construct(PaymentService $paymentService, PaymentDue $paymentDue) {
        $this->paymentService = $paymentService;
        $this->paymentDue = $paymentDue;
    }

    /**
     * Process the payment and validate the payment details.
     *
     * This method handles the payment processing and validation. It checks if the user has already paid
     * for the specified date range and verifies if the current due amount is sufficient for the payment.
     *
     * @param PaymentModel $payment The payment model representing the payment to be processed.
     * @return void
     * @throws UserAlreadyPaidException If the user has already paid for the specified date range.
     * @throws InsufficientAmountException If the current due amount is insufficient for the payment.
     */
    public function pay(PaymentModel $payment, UserModel $user) {
        $this->paymentValidation($payment, $user);
        $this->paymentService->pay($payment, $user);
    }

    /**
     * Get the details of unpaid dues for a specific user.
     *
     * This method retrieves the details of unpaid dues for a specific user.
     * It calculates the unpaid dues for each month between the initial payment date
     * and the current month.
     *
     * @param UserModel $model The user model representing the user for whom unpaid dues are fetched.
     * @return array An array containing the details of unpaid dues. Each element in the array has the 'month' and 'amount' keys.
     */
    public function getUnpaidDues(UserModel $model, UserModel $user) {

        $paymentDue = $this->paymentDue;
        $paymentService = $this->paymentService;

        $startMonth = $paymentDue->getInitialPaymentDate();

        $months = TimeHelper::getMonths($startMonth);

        $unpaidDues = [];

        foreach ($months as $month) {

            if ($paymentService->isPaid($user, $month, $month)) {
                continue;
            }

            $unpaidDues[] = [
                'month' => $month,
                'amount' => $paymentDue->getDueFor($month, $month)
            ];
        }

        return $unpaidDues;
    }

    /**
     * Get the details of paid dues for a specific user.
     *
     * This method retrieves the details of paid dues for a specific user.
     * It calculates the paid dues for each month between the initial payment date
     * and the current month.
     *
     * @param UserModel $model The user model representing the user for whom paid dues are fetched.
     * @return array An array containing the details of paid dues. Each element in the array has the 'month' and 'amount' keys.
     */
    public function getPaidDues(UserModel $user) {

        $paymentDue = $this->paymentDue;
        $paymentService = $this->paymentService;

        $startMonth = $paymentDue->getInitialPaymentDate();

        $months = TimeHelper::getMonths($startMonth);

        $paidDues = [];

        foreach ($months as $month) {

            if (!$paymentService->isPaid($user, $month, $month)) {
                continue;
            }

            $paidDues[] = [
                'month' => $month,
                'amount' => $paymentDue->getDueFor($month, $month)
            ];
        }

        return $paidDues;
    }

    /**
     * Validate the payment before processing.
     *
     * This method performs validation for the payment before processing it. It checks if the user has already paid
     * for the specified date range and verifies if the current due amount is sufficient for the payment.
     *
     * @param PaymentModel $payment The payment model representing the payment to be validated.
     * @return void
     * @throws UserAlreadyPaidException If the user has already paid for the specified date range.
     * @throws InsufficientAmountException If the current due amount is insufficient for the payment.
     */
    private function paymentValidation(PaymentModel $payment, UserModel $user) {

        $from = $payment->getFromDue();
        $to = $payment->getToDue();

        $paymentService = $this->paymentService;
        $paymentDue = $this->paymentDue;

        $amount = $payment->getAmount();

        $currentDue = $paymentDue->getDueFor($from, $to);

        if ($paymentService->isPaid($user, $from, $to)) {
            throw new UserAlreadyPaidException();
        }

        if ($currentDue > $amount) {
            throw new InsufficientAmountException();
        }
    }
}
<?php

namespace John\PaymentModule\model;

/**
 * The PaymentService interface defines methods to manage payments and dues.
 */
interface UserModel {

    public function getBlock();

    public function getLot();

    public function getPhase();
}
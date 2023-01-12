<?php

namespace App\Services;

use App\Interface\PaymentServiceInterface;

class PaypalAPI implements PaymentServiceInterface
{
    // private int $transaction_id;
    // public function __construct($transaction_id)
    // {
    //     $this->transaction_id = $transaction_id;
    // }
    // public function pay()
    // {
    //     return [
    //         'amount' => 123,
    //         'transaction_id' => $this->transaction_id,
    //     ];
    // }

    public function checkout(): string
    {
        return "checkout from paypal";
    }
}

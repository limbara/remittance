<?php

namespace App\Services\Api\Pay\Models;

use App\Enums\PaymentMethod;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CreditCardPay extends AbstractPay
{
  public function __construct(User $user, Transaction $transaction)
  {
    parent::__construct($user, $transaction);
  }

  protected function process(): Payment
  {
    DB::beginTransaction();
    try {
      $payment = Payment::create([
        'id' => Payment::generateID(),
        'transaction_id' => $this->transaction->id,
        'created_at' => $this->paymentDateTime->format('Y-m-d H:i:s'),
        'payment_method_id' => PaymentMethod::CREDIT_CARD
      ]);

      DB::commit();
      return $payment;
    } catch (\Exception $e) {

      DB::rollBack();
      throw $e;
    }
  }
}

<?php

namespace App\Services\Api\Pay\Models;

use App\Exceptions\Api\ErrorException;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;

abstract class AbstractPay
{
  /**
   * @var Transaction
   */
  protected $transaction;

  /**
   * @var User
   */
  protected $user;

  /**
   * @var Carbon
   */
  protected $paymentDateTime;

  public function __construct(User $user, Transaction $transaction)
  {
    $this->user = $user;
    $this->transaction = $transaction;
    $this->paymentDateTime = Carbon::now();
  }

  public function pay(): Payment
  {
    $this->checkTransactionValid();

    return $this->process();
  }

  protected function process(): Payment
  {
    throw new \Exception('Process not Implemented');
  }

  private function checkTransactionValid()
  {
    if ($this->transaction->isExpired()) {
      throw new ErrorException('Transaction has expired');
    }
  }
}

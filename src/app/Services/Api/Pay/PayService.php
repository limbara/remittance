<?php

namespace App\Services\Api\Pay;

use App\Enums\PaymentMethod;
use App\Exceptions\Api\NotFoundException;
use App\Models\Currency;
use App\Models\Payment;
use App\Models\User;
use App\Services\Api\Pay\Models\BankTransferPay;
use App\Services\Api\Pay\Models\CreditCardPay;

class PayService
{
  /**
   * pay a transaction
   * 
   * @param User $user
   * @param int $paymentMethodId
   * @param int $transactionId
   * @throws NotFoundException
   */
  public function pay(User $user, int $paymentMethodId, string $transactionId): Payment
  {
    $transaction = $user->transactions->where('id', $transactionId)->first();

    if (!$transaction) {
      throw new NotFoundException("Transaction Not Found");
    }

    $currency = Currency::find($transaction->currency_from);
    $country = $currency->country;
    $paymentMethod = $country->paymentMethods->where('id', $paymentMethodId)->first();

    if (!$paymentMethod) {
      throw new NotFoundException("Payment Method Not Found");
    }

    switch ($paymentMethodId) {
      case PaymentMethod::CREDIT_CARD:
        $pay = new CreditCardPay($user, $transaction);
        break;
      case PaymentMethod::BANK_TRANSFER:
        $pay = new BankTransferPay($user, $transaction);
        break;
      default:
        throw new NotFoundException('Payment Not Implemented');
    }

    return $pay->pay();
  }
}

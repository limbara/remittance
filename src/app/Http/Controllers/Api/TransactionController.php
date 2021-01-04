<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Transaction\PayRequest;
use App\Models\Payment;
use App\Models\Transaction;
use App\Services\Api\Pay\PayService;
use App\Services\Api\UserService;

class TransactionController extends Controller
{
  protected $payService, $userService;

  public function __construct(PayService $payService, UserService $userService)
  {
    $this->payService = $payService;
    $this->userService = $userService;
  }

  public function detail(string $transactionId)
  {
    $transaction = Transaction::find($transactionId);

    $payment = Payment::where('transaction_id', $transactionId)->first();

    return response()->json([
      'transaction' => $transaction,
      'payment' => $payment
    ]);
  }


  public function pay(PayRequest $payRequest, string $transactionId)
  {
    $user = $this->userService->find($payRequest->input('user_id'));

    $payment = $this->payService->pay(
      $user,
      $payRequest->input('payment_method_id'),
      $transactionId
    );

    return response()->json([
      'payment' => $payment
    ]);
  }
}

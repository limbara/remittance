<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Transaction\PayRequest;
use App\Services\Api\Pay\PayService;
use App\Services\Api\TransactionService;
use App\Services\Api\UserService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
  protected $payService, $userService, $transactionService;

  public function __construct(PayService $payService, UserService $userService, TransactionService $transactionService)
  {
    $this->payService = $payService;
    $this->userService = $userService;
    $this->transactionService = $transactionService;
  }

  public function detail(Request $request, string $transactionId)
  {
    $user = $this->userService->find($request->input('user_id'));

    $transaction = $this->transactionService->findUserTransaction($user, $transactionId);
    $transaction->payment;

    return response()->json([
      'transaction' => $transaction,
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

<?php

namespace App\Services\Api;

use App\Exceptions\Api\ErrorException;
use App\Exceptions\Api\NotFoundException;
use App\Models\Transaction;
use App\Models\User;

class TransactionService
{
  /**
   * @param User $user
   * @param string $transactionId
   * @return Transaction 
   * @throws NotFoundException
   */
  public function findUserTransaction(User $user, string $transactionId): Transaction
  {
    $transaction = $user->transactions()->where('id', $transactionId)->first();

    if (!$transaction) {
      throw new ErrorException('Transaction Not Found');
    }

    return $transaction;
  }
}

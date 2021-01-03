<?php

namespace App\Services\Api\Checkout\Models;

use App\Models\Bank;

class RegisteredRecipient extends AbstractRecipient
{
  public function __construct(string $firstName, string $lastName, string $email, string $accountNumber, Bank $bank, int $recipientId)
  {
    parent::__construct(
      $firstName,
      $lastName,
      $email,
      $accountNumber,
      $bank,
      $recipientId
    );
  }
}

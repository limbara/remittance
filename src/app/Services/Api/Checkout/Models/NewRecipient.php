<?php

namespace App\Services\Api\Checkout\Models;

use App\Models\Bank;

class NewRecipient extends AbstractRecipient
{
  public function __construct(string $firstName, string $lastName, string $email, string $accountNumber, Bank $bank)
  {
    parent::__construct(
      $firstName,
      $lastName,
      $email,
      $accountNumber,
      $bank
    );
  }
}

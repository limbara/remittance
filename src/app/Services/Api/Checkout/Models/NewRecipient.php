<?php

namespace App\Services\Api\Checkout\Models;

use App\Models\Bank;
use App\Models\Relationship;

class NewRecipient extends AbstractRecipient
{
  public function __construct(string $firstName, string $lastName, string $email, string $accountNumber, Bank $bank, Relationship $relationship)
  {
    parent::__construct(
      $firstName,
      $lastName,
      $email,
      $accountNumber,
      $bank,
      $relationship
    );
  }
}

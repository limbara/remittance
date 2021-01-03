<?php

namespace App\Services\Api\Checkout\Models;

use App\Models\Bank;

abstract class AbstractRecipient
{
  /**
   * @var int
   */
  public $recipientId;

  /**
   * @var string
   */
  public $firstName;

  /**
   * @var string
   */
  public $lastName;

  /**
   * @var string
   */
  public $email;

  /**
   * @var string
   */
  public $accountNumber;

  /**
   * @var Bank
   */
  public $bank;

  public function __construct(string $firstName = null, string $lastName = null, string $email = null, string $accountNumber = null, Bank $bank = null, int $recipientId = null)
  {
    $this->firstName = $firstName;
    $this->lastName = $lastName;
    $this->email = $email;
    $this->accountNumber = $accountNumber;
    $this->bank = $bank;
    $this->recipientId = $recipientId;
  }
}

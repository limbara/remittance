<?php

namespace App\Services\Api;

use App\Exceptions\Api\NotFoundException;
use App\Models\Bank;

class BankService
{
  /**
   * find bank
   * 
   * @param int $bankId
   * @return Bank 
   * @throws NotFoundException
   */
  public function find(int $bankId): Bank
  {
    $bank = Bank::find($bankId);

    if (!$bank) {
      throw new NotFoundException('Bank Not Found');
    }

    return $bank;
  }
}

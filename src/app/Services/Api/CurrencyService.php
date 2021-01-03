<?php

namespace App\Services\Api;

use App\Exceptions\Api\NotFoundException;
use App\Models\Currency;

class CurrencyService
{
  /**
   * @param string $currencyCode
   * @return Currrency
   * @throws NotFoundException
   */
  public function find(string $currencyCode): Currency
  {
    $currency = Currency::find($currencyCode);

    if (!$currency) {
      throw new NotFoundException('Currency Not Found');
    }

    return $currency;
  }
}

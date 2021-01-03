<?php

namespace App\Queries;

use App\Models\ExchangeRate;
use Carbon\Carbon;

class QueryExchangeRate
{
  public static function queryTodayLastExchangeRate(string $currencyFrom, string $currencyTo)
  {
    return self::queryTodayExchangeRates($currencyFrom, $currencyTo)
      ->orderBy('id', 'desc')
      ->limit(1);
  }

  public static function queryTodayExchangeRates(string $currencyFrom, string $currencyTo)
  {
    $now = Carbon::now();
    $StartDay = $now->startOfDay()->format('Y-m-d H:i:s');
    $EndDay = $now->endOfDay()->format('Y-m-d H:i:s');

    return self::queryExchangeRates($currencyFrom, $currencyTo)
      ->whereBetween('created_at', [$StartDay, $EndDay]);
  }

  public static function queryExchangeRates(string $currencyFrom, string $currencyTo)
  {
    return ExchangeRate::where('currency_from', $currencyFrom)
      ->where('currency_to', $currencyTo);
  }
}

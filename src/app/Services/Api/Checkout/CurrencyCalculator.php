<?php

namespace App\Services\Api\Checkout;

use App\Models\Currency;
use App\Models\ExchangeRate;
use App\Queries\QueryExchangeRate;

class CurrencyCalculator
{
  /**
   * @var Currency
   */
  private $currencyFrom;

  /**
   * @var Currency
   */
  private $currencyTo;

  /**
   * amount to send
   * 
   * @var int
   */
  private $amount;

  /**
   * @var ExchangeRate
   */
  private $exchangeRate;

  public function __construct(Currency $currencyFrom, Currency $currencyTo, int $amount)
  {
    $this->currencyFrom = $currencyFrom;
    $this->currencyTo = $currencyTo;
    $this->amount = $amount;

    $this->exchangeRate = QueryExchangeRate::queryTodayLastExchangeRate(
      $currencyFrom->currency_code,
      $currencyTo->currency_code
    )->first();
  }

  public function getCurrencyFrom(): Currency
  {
    return $this->currencyFrom;
  }

  public function getCurrencyTo(): Currency
  {
    return $this->currencyTo;
  }

  public function getLastExchangeRate(): ExchangeRate
  {
    if (!@$this->hasExchangeRate()) {
      return null;
    }

    return $this->exchangeRate;
  }

  public function hasExchangeRate()
  {
    return $this->exchangeRate ? true : false;
  }


  public function getConversionRate()
  {
    if (!$this->hasExchangeRate()) {
      return 0;
    }

    return $this->exchangeRate->conversion_rate;
  }

  public function getFee()
  {
    return $this->currencyFrom->transaction_fee;
  }

  public function getFeeMinorUnit()
  {
    return $this->currencyFrom->toMinorUnit($this->getFee());
  }

  public function getMinimumTransactionAmount()
  {
    return $this->currencyFrom->transaction_minimum_amount;
  }

  public function getMinimumTransactionAmountMinorUnit()
  {
    return $this->currencyFrom->toMinorUnit($this->getMinimumTransactionAmount());
  }

  public function getMaximumTransactionAmount()
  {
    return $this->currencyTo->transaction_maximum_amount;
  }

  public function getMaximumTransactionAmountMinorUnit()
  {
    return $this->currencyFrom->toMinorUnit($this->getMaximumTransactionAmount());
  }

  public function getAmount()
  {
    return $this->amount;
  }

  public function getAmountMinorUnit()
  {
    return $this->currencyFrom->toMinorUnit($this->getAmount());
  }

  public function getTransferredAmount()
  {
    if (!$this->hasExchangeRate()) {
      return 0;
    }

    $transferredAmount = round($this->amount / $this->getConversionRate(), $this->currencyTo->minor_unit, PHP_ROUND_HALF_UP);
    return $transferredAmount;
  }

  public function getTransferredAmountMinorUnit()
  { 
    return $this->currencyTo->toMinorUnit($this->getTransferredAmount());
  }

  public function getPointGained()
  {
    return 10;
  }

  public function isBelowMinimumTransactionAmount(): bool
  {
    return $this->getAmountMinorUnit() < $this->getMinimumTransactionAmountMinorUnit();
  }

  public function isAboveMaximumTransactionAmount(): bool
  {
    return $this->getAmountMinorUnit() > $this->getMaximumTransactionAmountMinorUnit();
  }
}

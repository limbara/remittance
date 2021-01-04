<?php

namespace App\Services\Api\Checkout;

use App\Enums\TransactionStatus as EnumsTransactionStatus;
use App\Exceptions\Api\ErrorException;
use App\Exceptions\Api\NotFoundException;
use App\Models\Country;
use App\Models\Recipient;
use App\Models\Transaction;
use App\Models\TransactionRequirement;
use App\Models\TransactionStatus;
use App\Models\User;
use App\Models\UserHasVoucher;
use App\Services\Api\Checkout\CurrencyCalculator;
use App\Services\Api\Checkout\Models\AbstractRecipient;
use App\Services\Api\Checkout\Models\NewRecipient;
use App\Services\Api\Checkout\Models\NoRecipient;
use App\Services\Api\Checkout\Models\RegisteredRecipient;
use App\Services\Api\Checkout\VoucherObject;
use App\Services\Api\NotificationService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CheckoutService
{
  /**
   * @var CurrencyCalculator
   */
  private $currencyCalculator;

  /**
   * @var User
   */
  private $user;

  /**
   * @var Country
   */
  private $countryFrom;

  /**
   * @var Country
   */
  private $countryTo;

  /**
   * @var Currency
   */
  private $currencyFrom;

  /**
   * @var Currency
   */
  private $currencyTo;

  /**
   * @var int
   */
  private $userVoucherId;

  /**
   * @var VoucherObject
   */
  private $voucherObject = null;

  /**
   * @var Collection Collection<TransactionRequirement>
   */
  private $transactionRequirements;

  /**
   * @var AbstractRecipient
   */
  private $recipient;

  /**
   * @var array array key value requirements
   */
  private $requirements;

  public function __construct(User $user, Country $countryFrom, Country $countryTo, int $amount, AbstractRecipient $recipient, int $userVoucherId = null, array $requirements = [])
  {
    $this->user = $user;
    $this->countryFrom = $countryFrom;
    $this->countryTo = $countryTo;
    $this->currencyFrom = $countryFrom->currency;
    $this->currencyTo = $countryTo->currency;
    $this->userVoucherId = $userVoucherId;
    $this->requirements = $requirements;
    $this->transactionRequirements = $this->countryFrom->transactionRequirements;
    $this->recipient = $recipient;

    $this->loadAndCheckVoucher();
    $this->currencyCalculator = new CurrencyCalculator($this->currencyFrom, $this->currencyTo, $amount);
  }

  public function checkout(): Transaction
  {
    $this->checkRecipient();
    $this->checkAmount();
    $this->checkTransactionAmountLimit();
    $this->checkTransactionRequirement();

    DB::beginTransaction();
    try {
      $checkoutTime = Carbon::now();
      $recipient = $this->recipient;
      switch (get_class($recipient)) {
        case NewRecipient::class:
          $newRecipient = Recipient::create([
            'first_name' => $recipient->firstName,
            'last_name' => $recipient->lastName,
            'email' => $recipient->email,
            'account_number' => $recipient->accountNumber,
            'bank_id' => $recipient->bank->id,
            'relationship_id' => $recipient->relationship->id,
            'user_id' => $this->user->id
          ]);

          $recipientId = $newRecipient->id;
          break;
        case RegisteredRecipient::class:
          Recipient::where('id', $recipient->recipientId)
            ->update([
              'first_name' => $recipient->firstName,
              'last_name' => $recipient->lastName,
              'email' => $recipient->email,
              'account_number' => $recipient->accountNumber,
              'bank_id' => $recipient->bank->id,
              'relationship_id' => $recipient->relationship->id
            ]);

          $recipientId = $recipient->recipientId;
          break;
        default:
          throw new ErrorException('Recipient is not valid');
      }

      $transaction = Transaction::create([
        'id' => Transaction::generateID(),
        'currency_from' => $this->currencyFrom->currency_code,
        'currency_to' => $this->currencyTo->currency_code,
        'conversion_rate' => $this->getConversionRate(),
        'total_amount' => $this->getTotalAmountMinorUnit(),
        'transfer_amount' => $this->getTransferredAmountMinorUnit(),
        'amount' => $this->getAmountMinorUnit(),
        'point' => $this->currencyCalculator->getPointGained(),
        'fee' => $this->getFeeMinorUnit(),
        'discount' => $this->getDiscountMinorUnit(),
        'requirements' => json_encode($this->requirements),
        'created_at' => $checkoutTime->format('Y-m-d H:i:s'),
        'expired_at' => Transaction::generateExpiredDate($checkoutTime)->format('Y-m-d H:i:s'),
        'user_id' => $this->user->id,
        'voucher_id' => $this->isUsingVoucher() ? $this->voucherObject->getId() : null,
        'recipient_id' => $recipientId
      ]);

      TransactionStatus::create([
        'transaction_id' => $transaction->id,
        'status' => EnumsTransactionStatus::PENDING,
        'created_at' => $checkoutTime->format('Y-m-d H:i:s')
      ]);

      // delete used voucher
      if ($this->isUsingVoucher()) {
        UserHasVoucher::find($this->userVoucherId)->delete();
      }

      NotificationService::notifyTransactionCreated($transaction, $this->user);

      DB::commit();

      return $transaction;
    } catch (\Exception $e) {
      DB::rollBack();
      throw $e;
    }
  }

  public function getDiscountMinorUnit()
  {
    if (!$this->isUsingVoucher()) {
      return 0;
    }

    $voucherValue = $this->voucherObject->getVoucherValueOf($this->currencyFrom->currency_code);
    $maxDiscount = $voucherValue->amount;

    if ($this->voucherObject->isVoucherTypeFee()) {
      $fee = $this->getFeeMinorUnit();
      $maxDiscount = $fee - $maxDiscount < 0 ? $fee : $maxDiscount;
    }

    return $maxDiscount;
  }

  public function getDiscount()
  {
    return $this->currencyFrom->toNormalUnit($this->getDiscountMinorUnit());
  }

  public function getFeeMinorUnit()
  {
    return $this->currencyCalculator->getFeeMinorUnit();
  }

  public function getFee()
  {
    return $this->currencyFrom->toNormalUnit($this->getFeeMinorUnit());
  }

  public function getTotalAmountMinorUnit()
  {
    $discount = $this->getDiscountMinorUnit();
    $fee = $this->getFeeMinorUnit();
    $amount = $this->getAmountMinorUnit();

    return $amount + $fee - $discount;
  }

  public function getTotalAmount()
  {
    return $this->currencyFrom->toNormalUnit($this->getTotalAmountMinorUnit());
  }

  public function getAmountMinorUnit()
  {
    return $this->currencyCalculator->getAmountMinorUnit();
  }

  public function getAmount()
  {
    return $this->currencyFrom->toNormalUnit($this->getAmountMinorUnit());
  }

  public function getTransferredAmountMinorUnit()
  {
    return $this->currencyCalculator->getTransferredAmountMinorUnit();
  }

  public function getTransferredAmount()
  {
    return $this->currencyTo->toNormalUnit($this->getTransferredAmountMinorUnit());
  }

  public function getConversionRate()
  {
    return $this->currencyCalculator->getConversionRate();
  }

  public function getPointGained()
  {
    return $this->currencyCalculator->getPointGained();
  }

  public function getTransactionRequirements(): Collection
  {
    return $this->transactionRequirements;
  }

  private function isUsingVoucher()
  {
    return $this->voucherObject != null;
  }

  private function checkRecipient()
  {
    if ($this->recipient instanceof NoRecipient) {
      throw new ErrorException('Recipient is not valid');
    }
  }

  private function checkAmount()
  {
    if ($this->currencyCalculator->getAmount() === 0) {
      throw new ErrorException('Amount must not be 0');
    }
  }

  private function checkTransactionRequirement()
  {
    $this->transactionRequirements->each(function (TransactionRequirement $transactionRequirement) {
      if (!isset($this->requirements[$transactionRequirement->key])) {
        throw new ErrorException("{$this->countryFrom->country_name}'s transaction has no {$transactionRequirement->key}");
      }
    });
  }

  private function checkTransactionAmountLimit()
  {
    return !$this->currencyCalculator->isAboveMaximumTransactionAmount() && !$this->currencyCalculator->isBelowMinimumTransactionAmount();
  }

  private function loadAndCheckVoucher()
  {
    if (!$this->userVoucherId) {
      return;
    }

    $voucher = $this->user->vouchers()->wherePivot('id', $this->userVoucherId)->first();

    if (!$voucher) {
      throw new NotFoundException('Voucher Not Found');
    }

    $this->voucherObject = new VoucherObject($voucher);

    if (!$this->voucherObject->hasVoucherValueOf($this->currencyFrom->currency_code)) {
      throw new ErrorException("Voucher is not eligible for currency {$this->currencyFrom->currency_code}");
    }

    if (!$this->voucherObject->isValid()) {
      $from = $this->voucherObject->getValidFrom()->format('MMM, D H:i');
      $to = $this->voucherObject->getValidTo()->format('MMM, D H:i');

      throw new ErrorException("Voucher can only be used between {$from} and {$to}");
    }
  }
}

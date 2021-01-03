<?php

namespace App\Services\Api\Checkout;

use App\Enums\VoucherType;
use App\Models\Voucher;
use App\Models\VoucherValue;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class VoucherObject
{
  /**
   * @var int
   */
  protected $id;

  /**
   * @var int
   */
  protected $pointCost;

  /**
   * @var Carbon
   */
  protected $validFrom;

  /**
   * @var Carbon
   */
  protected $validTo;

  /**
   * @var Collection Collection<VoucherValue>
   */
  protected $voucherValues;

  /**
   * @var VoucherType
   */
  protected $voucherType;

  public function __construct(Voucher $voucher)
  {
    $this->id = $voucher->id;
    $this->pointCost = $voucher->point_cost;
    $this->validFrom = Carbon::createFromDate($voucher->valid_from);
    $this->validTo = Carbon::createFromDate($voucher->valid_to);

    $this->voucherValues = $voucher->voucherValues;
    $this->voucherType = $voucher->voucherType;
  }

  public function getId(): int
  {
    return $this->id;
  }

  public function getPointCost(): int
  {
    return $this->pointCost;
  }

  public function getValidFrom(): Carbon
  {
    return $this->validFrom;
  }

  public function getValidTo(): Carbon
  {
    return $this->validTo;
  }

  public function isVoucherTypeFee(): bool
  {
    return $this->voucherType->id == VoucherType::DISCOUNT_FEE;
  }

  public function getVoucherValueOf(string $currencyCode): VoucherValue
  {
    return $this->voucherValues->where('currency_code', $currencyCode)->first();
  }

  public function hasVoucherValueOf(string $currencyCode): bool
  {
    return $this->getVoucherValueOf($currencyCode) ? true : false;
  }

  public function isValid(): bool
  {
    return $this->validFrom->isPast() && !$this->validTo->isPast();
  }
}

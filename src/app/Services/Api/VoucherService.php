<?php

namespace App\Services\Api;

use App\Exceptions\Api\NotFoundException;
use App\Models\Voucher;

class VoucherService
{
  /**
   * @param string $voucherId
   * @return Voucher
   * @throws NotFoundException
   */
  public function find(string $voucherId): Voucher
  {
    $voucher = Voucher::find($voucherId);

    if (!$voucher) {
      throw new NotFoundException('Voucher Not Found');
    }

    return $voucher;
  }
}

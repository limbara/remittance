<?php

namespace App\Services\Api;

use App\Enums\PointHistoryType;
use App\Exceptions\Api\NotFoundException;
use App\Models\User;
use App\Models\UserHasVoucher;
use App\Models\Voucher;
use Carbon\Carbon;
use ErrorException;
use Illuminate\Support\Facades\DB;

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

  public function redeemVoucher(Voucher $voucher, User $user): Voucher
  {
    $userPointService = new UserPointService($user);
    $pointCost = $voucher->point_cost;
    $isPointSufficient = $userPointService->isPointAvailable() && $userPointService->getPoint() > $pointCost;

    if (!$isPointSufficient) {
      throw new ErrorException("{$pointCost} point needed");
    }

    DB::beginTransaction();
    try {
      UserHasVoucher::create([
        'user_id' => $user->id,
        'voucher_id' => $voucher->id
      ]);

      $userPointService->createTransaction(
        'Redeem Voucher',
        PointHistoryType::OUT,
        $pointCost,
        Carbon::now()
      );

      DB::commit();
      return $voucher;
    } catch (\Exception $e) {

      DB::rollBack();
      throw $e;
    }
  }
}

<?php

namespace App\Http\Controllers\Api;

use App\Services\Api\UserService;
use App\Services\Api\VoucherService;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
  protected $voucherService, $userService;

  public function __construct(VoucherService $voucherService, UserService $userService)
  {
    $this->voucherService = $voucherService;
    $this->userService = $userService;
  }

  public function redeem(Request $request, int $voucherId)
  {
    $user = $this->userService->find($request->input('user_id'));

    $voucher = $this->voucherService->find($voucherId);

    $v = $this->voucherService->redeemVoucher($voucher, $user);

    return response()->json([
      'voucher' => $v
    ]);
  }
}

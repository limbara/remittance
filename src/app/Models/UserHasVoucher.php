<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class UserHasVoucher extends Pivot
{
  protected $table = 'user_has_vouchers';

  use HasFactory;

  protected $fillable = [
    'user_id',
    'voucher_id'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function voucher()
  {
    return $this->belongsTo(Voucher::class);
  }
}

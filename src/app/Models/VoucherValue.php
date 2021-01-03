<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherValue extends Model
{
  use HasFactory;

  protected $fillable = [
    'amount',
    'currency_code',
  ];

  public function voucher()
  {
    return $this->belongsTo(Voucher::class);
  }
}

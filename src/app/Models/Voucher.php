<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voucher extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'point_cost',
    'valid_from',
    'valid_to',
  ];

  public function voucherValues()
  {
    return $this->hasMany(VoucherValue::class);
  }

  public function transactions()
  {
    return $this->hasMany(Transaction::class);
  }

  public function voucherType()
  {
    return $this->belongsTo(VoucherType::class);
  }
}

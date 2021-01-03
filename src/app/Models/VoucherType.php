<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VoucherType extends Model
{
  use HasFactory;

  public $incrementing = false;

  protected $fillable = [
    'id',
    'description',
  ];

  public function vouchers()
  {
    return $this->hasMany(Voucher::class);
  }
}

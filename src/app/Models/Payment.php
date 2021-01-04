<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Payment extends Model
{
  use HasFactory;

  public $incrementing = false;

  public $timestamps = false;

  protected $keyType = 'string';

  protected $fillable = [
    'id',
    'transaction_id',
    'payment_method_id',
    'created_at'
  ];

  public function transaction()
  {
    return $this->belongsTo(Transaction::class);
  }

  public function paymentMethod()
  {
    return $this->belongsTo(PaymentMethod::class);
  }

  public function paymentStatuses()
  {
    return $this->hasMany(PaymentStatus::class);
  }
  
  public static function generateID(): string
  {
    return Str::uuid();
  }
}

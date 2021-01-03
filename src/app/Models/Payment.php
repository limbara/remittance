<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
  use HasFactory;

  public $incrementing = false;

  public $timestamps = false;

  protected $keyType = 'string';

  protected $fillable = [
    'id',
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
}

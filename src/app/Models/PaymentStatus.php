<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
  use HasFactory;

  public $timestamps = false;

  protected $fillable = [
    'payment_id',
    'status',
    'created_at'
  ];

  public function payment()
  {
    return $this->belongsTo(Payment::class);
  }
}

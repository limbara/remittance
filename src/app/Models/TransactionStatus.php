<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionStatus extends Model
{
  use HasFactory;

  public $timestamps = false;

  protected $fillable = [
    'transaction_id',
    'status',
    'created_at'
  ];

  public function transaction()
  {
    return $this->belongsTo(Transaction::class);
  }
}

<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
  const EXPIRED_HOUR = 1;

  use HasFactory;

  public $timestamps = false;

  public $incrementing = false;

  protected $keyType = 'string';

  protected $fillable = [
    'id',
    'currency_from',
    'currency_to',
    'conversion_rate',
    'total_amount',
    'transfer_amount',
    'amount',
    'point',
    'fee',
    'discount',
    'requirements',
    'expired_at',
    'created_at',
    'user_id',
    'voucher_id',
    'recipient_id'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function recipient()
  {
    return $this->belongsTo(Recipient::class);
  }

  public function voucher()
  {
    return $this->belongsTo(Voucher::class);
  }

  public function transactionStatuses()
  {
    return $this->hasMany(TransactionStatus::class);
  }

  public static function generateID()
  {
    return Str::uuid();
  }

  public static function generateExpiredDate(Carbon $checkoutDateTime): Carbon
  {
    return $checkoutDateTime->clone()->addHours(self::EXPIRED_HOUR);
  }
}

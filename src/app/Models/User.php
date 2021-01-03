<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
  use HasFactory, Notifiable;

  protected $fillable = [
    'phone_number',
    'email',
    'point',
  ];

  public function userPointHistories()
  {
    return $this->hasMany(UserPointHistory::class);
  }

  public function transactions()
  {
    return $this->hasMany(Transaction::class);
  }

  public function vouchers()
  {
    return $this->belongsToMany(Voucher::class, 'user_has_vouchers')->using(UserHasVoucher::class);
  }

  public function userProfile()
  {
    return $this->hasOne(UserProfile::class);
  }

  public function recipients()
  {
    return $this->hasMany(Recipient::class);
  }

  public function isVerified()
  {
    return $this->verified;
  }
}

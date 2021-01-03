<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recipient extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'first_name',
    'last_name',
    'email',
    'account_number',
    'city_id',
    'user_id'
  ];

  public function bank()
  {
    return $this->belongsTo(Bank::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function relationship()
  {
    return $this->belongsTo(Relationship::class);
  }

  public function transactions()
  {
    return $this->hasMany(Transaction::class);
  }
}

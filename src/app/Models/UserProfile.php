<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
  use HasFactory;

  protected $fillable = [
    'first_name',
    'last_name',
    'birth_date',
    'legal_identifier',
    'address',
    'gender',
    'photo',
    'verified',
    'user_id',
    'city_id'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function city()
  {
    return $this->belongsTo(City::class);
  }
}

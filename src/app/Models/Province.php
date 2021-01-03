<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Province extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'province_name',
    'status',
  ];

  public function cities()
  {
    return $this->hasMany(City::class);
  }

  public function country()
  {
    return $this->belongsTo(Country::class);
  }
}

<?php

namespace App\Models;

use App\Enums\CityStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'city_name',
    'status',
  ];

  public function province()
  {
    return $this->belongsTo(Province::class);
  }

  public function isActive()
  {
    return $this->status == CityStatus::ACTIVE;
  }

  public function isInactive()
  {
    return $this->status = CityStatus::INACTIVE;
  }
}

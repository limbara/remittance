<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationType extends Model
{
  use HasFactory, SoftDeletes;

  public $incrementing = false;

  protected $fillable = [
    'id',
    'name',
  ];

  public function notifications()
  {
    return $this->hasMany(Notification::class);
  }
}

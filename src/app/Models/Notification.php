<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'title',
    'body',
    'read_at',
    'user_id',
    'notification_type_id'
  ];

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function notificationType()
  {
    return $this->belongsTo(NotificationType::class);
  }
}

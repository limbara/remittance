<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Relationship extends Model
{
  use HasFactory, SoftDeletes;

  public $incrementing = false;

  protected $fillable = [
    'id',
    'description',
  ];

  public function recipients()
  {
    return $this->hasMany(Recipient::class);
  }
}

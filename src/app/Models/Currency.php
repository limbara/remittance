<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
  use HasFactory, SoftDeletes;

  public $incrementing = false;

  protected $primaryKey  = 'currency_code';

  protected $keyType = 'string';

  protected $fillable = [
    'currency_code',
    'currency_name',
    'currency_symbol_unicode',
    'minor_unit',
    'transaction_fee',
    'transaction_minimum_amount',
    'transaction_maximum_amount',
  ];

  public function country()
  {
    return $this->belongsTo(Country::class);
  }

  public function toMinorUnit(float $amount)
  {
    return $amount * pow(10, $this->minor_unit);
  }

  public function toNormalUnit(float $amount)
  {
    return $amount / pow(10, $this->minor_unit);
  }
}

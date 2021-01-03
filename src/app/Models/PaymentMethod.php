<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
  use HasFactory;

  public $incrementing = false;

  protected $fillable = [
    'id',
    'name'
  ];

  public function countries()
  {
    return $this->belongsToMany(Country::class, 'country_has_payment_methods')->using(CountryHasPaymentMethod::class);
  }

  public function payments()
  {
    return $this->hasMany(Payment::class);
  }
}

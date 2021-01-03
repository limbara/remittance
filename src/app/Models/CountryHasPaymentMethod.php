<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CountryHasPaymentMethod extends Pivot
{
  protected $table = 'country_has_payment_methods';

  use HasFactory;

  protected $fillable = [
    'status'
  ];

  public function country()
  {
    return $this->belongsTo(Country::class);
  }

  public function paymentMethod()
  {
    return $this->belongsTo(PaymentMethod::class);
  }
}

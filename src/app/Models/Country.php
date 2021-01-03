<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Country extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'country_name',
    'country_code',
    'country_flag_unicode',
    'status'
  ];

  public function currency()
  {
    return $this->hasOne(Currency::class);
  }

  public function banks()
  {
    return $this->hasMany(Bank::class);
  }

  public function provinces()
  {
    return $this->hasMany(Province::class);
  }

  public function transactionRequirements()
  {
    return $this->belongsToMany(TransactionRequirement::class, 'country_has_transaction_requirements')->using(CountryHasTransactionRequirement::class);
  }

  public function paymentMethods()
  {
    return $this->belongsToMany(PaymentMethod::class, 'country_has_payment_methods')->using(CountryHasPaymentMethod::class);
  }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CountryHasTransactionRequirement extends Pivot
{
  protected $table = 'country_has_transaction_requirements';

  use HasFactory;

  public function country()
  {
    return $this->belongsTo(Country::class);
  }

  public function transactionRequirement()
  {
    return $this->belongsTo(TransactionRequirement::class, 'transaction_requirement_key', 'key');
  }
}

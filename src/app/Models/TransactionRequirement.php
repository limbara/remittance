<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionRequirement extends Model
{
  use HasFactory;

  public $incrementing = false;

  protected $primaryKey = 'key';

  protected $keyType = 'string';

  protected $fillable = [
    'key',
    'description',
  ];

  public function countries()
  {
    return $this->belongsToMany(Country::class, 'country_has_transaction_requirements', 'transaction_requirement_key', 'key')->using(CountryHasTransactionRequirement::class);
  }
}

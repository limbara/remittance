<?php

namespace App\Http\Requests\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class PreCheckoutRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'country_from' => 'required|int|exists:countries,id',
      'country_to' => 'required|int|exists:countries,id',
      'amount' => 'required|numeric|min:1',
      'user_voucher_id' => 'int'
    ];
  }
}

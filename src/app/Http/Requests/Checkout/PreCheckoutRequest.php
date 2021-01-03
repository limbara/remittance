<?php

namespace App\Http\Requests\Checkout;

use App\Exceptions\Api\ErrorException;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;

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

  protected function failedValidation(Validator $validator)
  {
    throw new ErrorException($validator->errors()->first());
  }
}

<?php

namespace App\Http\Requests\Transaction;

use App\Exceptions\Api\ErrorException;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;

class PayRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'payment_method_id' => 'required|int',
    ];
  }

  protected function failedValidation(Validator $validator)
  {
    throw new ErrorException($validator->errors()->first());
  }
}

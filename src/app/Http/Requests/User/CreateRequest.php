<?php

namespace App\Http\Requests\User;

use App\Exceptions\Api\ErrorException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class CreateRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'phone_number' => 'required|string|max:20|valid_phone_for_code:country_code',
      'email' => 'required|string|email|max:254|unique:users,email',
      'country_code' => 'required|string|exists:countries,country_code'
    ];
  }

  protected function failedValidation(Validator $validator)
  {
    throw new ErrorException($validator->errors()->first());
  }
}

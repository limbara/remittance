<?php

namespace App\Http\Requests\Profile;

use App\Exceptions\Api\ErrorException;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
{
  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    $beforeDate = Carbon::now()->subYears(12)->format('Y-m-d');

    return [
      'first_name' => 'required|string|max:100',
      'last_name' => 'required|string|max:100',
      'birth_date' => "required|date|before:{$beforeDate}",
      'legal_identifier' => 'required|string|max:100',
      'address' => 'required|string',
      'gender' => 'required|int|valid_profile_gender',
      'photo' => 'required|image|mimes:jpg,jpeg,png|max:5000',
      'city_id' => 'required|int|exists:cities,id',
    ];
  }

  protected function failedValidation(Validator $validator)
  {
    throw new ErrorException($validator->errors()->first());
  }
}

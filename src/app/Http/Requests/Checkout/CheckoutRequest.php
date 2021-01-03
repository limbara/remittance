<?php

namespace App\Http\Requests\Checkout;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
      'amount' => 'required|numeric',
      'user_voucher_id' => 'int',
      'recipient_id' => 'int|required_without_all:recipient.first_name,recipient.last_name,recipient.email,new_recipient.account_number',
      'recipient.first_name' => 'required_with_all:recipient.last_name,recipient.email,recipient.account_number,recipient.bank_id|string|max:100',
      'recipient.last_name' => 'required_with_all:recipient.first_name,recipient.email,recipient.account_number,recipient.bank_id|string|max:100',
      'recipient.email' => 'required_with_all:recipient.first_name,recipient.last_name,recipient.account_number,recipient.bank_id|string:max:254',
      'recipient.account_number' => 'required_with_all:recipient.first_name,recipient.last_name,recipient.email,recipient.bank_id|string|max:100',
      'recipient.bank_id' => 'required_with_all:recipient.first_name,recipient.last_name,recipient.email,recipient.account_number|int',
      'requirements' => 'json'
    ];
  }
}

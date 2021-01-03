<?php

namespace App\Providers;

use App\Utils\ValidationUtils;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    Validator::extend('valid_profile_gender', function ($attribute, $value) {
      return ValidationUtils::isValidProfileGender($value);
    });

    Validator::extend('valid_phone', function ($attribute, $value, $parameters, $validator) {
      $countryCodeKey = $parameters[0] ?? null;
      $data = $validator->getData();

      if ($countryCodeKey) {
        $countryCode = $data[$countryCodeKey];
      } else {
        $countryCode = null;
      }

      return ValidationUtils::isValidPhone($value, $countryCode);
    });

    Validator::extend('valid_phone_for_code', function ($attribute, $value, $parameters, $validator) {
      $countryCodeKey = $parameters[0] ?? null;
      $data = $validator->getData();

      if ($countryCodeKey) {
        $countryCode = $data[$countryCodeKey];
      } else {
        $countryCode = null;
      }

      return ValidationUtils::isValidPhoneForCode($value, $countryCode);
    });
  }
}

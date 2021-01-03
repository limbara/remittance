<?php

namespace App\Utils;

use App\Enums\ProfileGender;
use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberUtil;

class ValidationUtils
{
  /**
   * Check if $value is valid Profile
   * 
   * @param string|int $value 
   * @return boolean
   */
  public static function isValidProfileGender($value)
  {
    $value = is_string($value) ? (int) $value : $value;

    return in_array($value, [
      ProfileGender::MAN,
      ProfileGender::WOMAN
    ]);
  }

  /**
   * Check if phone is valid
   * 
   * @param string $phoneNumber
   * @param string $countryCode default to null
   * @return boolean
   */
  public static function isValidPhone($phoneNumber, $countryCode = null)
  {

    $phoneNumberUtil = PhoneNumberUtil::getInstance();

    try {
      $phoneNumberObject = $phoneNumberUtil->parse($phoneNumber, $countryCode);
    } catch (NumberParseException $e) {
      return false;
    }

    return $phoneNumberUtil->isValidNumber($phoneNumberObject);
  }

  /**
   * Check if phone is valid base on country code
   * 
   * @param string $phoneNumber
   * @param string $countryCode
   * @return boolean
   */
  public static function isValidPhoneForCode($phoneNumber, $countryCode)
  {

    $phoneNumberUtil = PhoneNumberUtil::getInstance();

    try {
      $phoneNumberObject = $phoneNumberUtil->parse($phoneNumber, $countryCode);
    } catch (NumberParseException $e) {
      return false;
    }

    return $phoneNumberUtil->isValidNumber($phoneNumberObject) && $phoneNumberUtil->isValidNumberForRegion($phoneNumberObject, $countryCode);
  }
}

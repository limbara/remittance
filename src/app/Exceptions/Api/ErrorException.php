<?php

namespace App\Exceptions\Api;

use Exception;

class ErrorException extends Exception
{
  public function render()
  {
    return response()->json([
      'error_code' => $this->code ? $this->code : 400,
      'error_message' => $this->message ? $this->message : 'Error. Something is missing.',
    ], 400);
  }
}

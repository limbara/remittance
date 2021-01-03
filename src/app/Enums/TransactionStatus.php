<?php

namespace App\Enums;

class TransactionStatus
{
  const PENDING = 0;
  const APPROVED = 1;
  const REJECTED = 2;
  const EXPIRED = 3;
  const CANCELLED = 4;
  const SUCCESS = 5;
}

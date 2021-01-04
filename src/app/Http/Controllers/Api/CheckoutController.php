<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Checkout\CheckoutRequest;
use App\Http\Requests\Checkout\PreCheckoutRequest;
use App\Services\Api\BankService;
use App\Services\Api\Checkout\CheckoutService;
use App\Services\Api\Checkout\Models\NewRecipient;
use App\Services\Api\Checkout\Models\NoRecipient;
use App\Services\Api\Checkout\Models\RegisteredRecipient;
use App\Services\Api\CountryService;
use App\Services\Api\RecipientService;
use App\Services\Api\RelationshipService;
use App\Services\Api\UserService;

class CheckoutController extends Controller
{
  protected $userService, $countryService, $recipientService, $bankService, $relationshipService;

  public function __construct(UserService $userService, CountryService $countryService, RecipientService $recipientService, BankService $bankService, RelationshipService $relationshipService)
  {
    $this->userService = $userService;
    $this->countryService = $countryService;
    $this->recipientService = $recipientService;
    $this->bankService = $bankService;
    $this->relationshipService = $relationshipService;
  }

  public function precheckout(PreCheckoutRequest $preCheckoutRequest)
  {
    $user = $this->userService->find($preCheckoutRequest->input('user_id'));

    $countryFrom = $this->countryService->find($preCheckoutRequest->input('country_from'));

    $countryTo = $this->countryService->find($preCheckoutRequest->input('country_to'));

    $checkoutService = new CheckoutService(
      $user,
      $countryFrom,
      $countryTo,
      $preCheckoutRequest->input('amount'),
      new NoRecipient(),
      $preCheckoutRequest->input('user_voucher_id', null),
      []
    );

    return response()->json([
      'conversion_rate' => $checkoutService->getConversionRate(),
      'total_amount' => $checkoutService->getTotalAmount(),
      'transfer_amount' => $checkoutService->getTransferredAmount(),
      'amount' => $checkoutService->getAmount(),
      'point' => $checkoutService->getPointGained(),
      'fee' => $checkoutService->getFee(),
      'discount' => $checkoutService->getDiscount(),
      'requirements' => $checkoutService->getTransactionRequirements()->reduce(function ($carry, $item) {
        $carry[] = $item->key;
        return $carry;
      }, [])
    ]);
  }

  public function checkout(CheckoutRequest $checkoutRequest)
  {
    $user = $this->userService->find($checkoutRequest->input('user_id'));

    $countryFrom = $this->countryService->find($checkoutRequest->input('country_from'));

    $countryTo = $this->countryService->find($checkoutRequest->input('country_to'));

    $recipientId = $checkoutRequest->input('recipient_id', null);

    if ($recipientId) {
      $savedRecipient = $this->recipientService->findUserRecipient($user, $recipientId);
      $bank = $this->bankService->find($checkoutRequest->input('recipient.bank_id', $savedRecipient->bank_id));
      $relationship = $this->relationshipService->find($checkoutRequest->input('recipient.relationship_id', $savedRecipient->relationship_id));

      $recipient = new RegisteredRecipient(
        $checkoutRequest->input('recipient.first_name', $savedRecipient->first_name),
        $checkoutRequest->input('recipient.last_name', $savedRecipient->last_name),
        $checkoutRequest->input('recipient.email', $savedRecipient->email),
        $checkoutRequest->input('recipient.account_number', $savedRecipient->account_number),
        $bank,
        $relationship,
        $savedRecipient->id
      );
    } else {
      $bank = $this->bankService->find($checkoutRequest->input('recipient.bank_id'));
      $relationship = $this->relationshipService->find($checkoutRequest->input('recipient.relationship_id'));

      $recipient = new NewRecipient(
        $checkoutRequest->input('recipient.first_name'),
        $checkoutRequest->input('recipient.last_name'),
        $checkoutRequest->input('recipient.email'),
        $checkoutRequest->input('recipient.account_number'),
        $bank,
        $relationship
      );
    }

    $checkoutService = new CheckoutService(
      $user,
      $countryFrom,
      $countryTo,
      $checkoutRequest->input('amount'),
      $recipient,
      $checkoutRequest->input('user_voucher_id', null),
      (array) json_decode($checkoutRequest->input('requirements'))
    );

    $transaction = $checkoutService->checkout();

    return response()->json([
      'transaction' => $transaction
    ]);
  }
}

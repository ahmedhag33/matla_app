<?php

namespace App\Service\Payment\Gatway;

use App\Exceptions\PaymentException;
use App\Service\Enum\HttpStatusCode;
use App\Service\Enum\PaymentGatway;
use App\Service\Payment\PaymentGateway;
use App\Service\Payment\PaymentGatewayInterFace;

class PayTab extends PaymentGateway implements PaymentGatewayInterFace
{
    // tran_type
   protected const TRAN_TYPE = 'sale';
    // hide_shipping
   protected const HIDE_SHIPPING = true;
    // tran_class
   protected const TRAN_CLASS = 'ecom';
   // cart_description
   protected const CART_DESCRIPTION = 'Sample Payment';
   /**
     * The payment gateway to use for this request.
     *
     * @var string */
    protected $paymentGateway = PaymentGatway::PAYTAB->value;
     /**
     * Build the provider-specific payload for creating a payment request.
     *
     * @param float  $price     Amount to charge, in the gateway's currency.
     * @param string $returnUrl URL the provider redirects to after a successful payment.
     * @param string $cancelUrl URL the provider redirects to when the customer cancels.
     *
     * @return array<string, mixed> Request body sent to the payment provider.
     */
    // Build the provider-specific payload for creating a payment request.
    protected function requestModel(float $price, string $returnUrl, string $cancelUrl): array
    {
        return [
            "profile_id" => env('PAYTAB_PROFILEID'),
            "tran_type" => self::TRAN_TYPE,
            "tran_class" => self::TRAN_CLASS,
            "cart_id" => createToken(4),
            "cart_description" => self::CART_DESCRIPTION,
            "cart_currency" => env('APP_CURRENCY'),
            "cart_amount" => $price,
            "hide_shipping" => self::HIDE_SHIPPING,
            "return" => $returnUrl,
            "paypage_lang" => app()->getLocale()
        ];
    }
    /**
     * Initiate a payment with the provider and return the checkout details.
     *
     * @param float  $price     Amount to charge, in the gateway's currency.
     * @param string $returnUrl URL the provider redirects to after a successful payment.
     * @param string|null $cancelUrl URL the provider redirects to when the customer cancels.
     *
     * @return array
     * @throws PaymentException When the provider rejects the request.
     */
    public function paymentTransaction(float $price, string $returnUrl, $cancelUrl = '')
    {
        $body = $this->requestModel($price, $returnUrl, $cancelUrl);
        // Build the payment request
        $response = $this->buildPaymentRequest($body);
        // Check if the payment request was successful
        if (!$response) {
            throw new PaymentException('Payment' . $this->paymentGateway . 'failed', HttpStatusCode::BAD_REQUEST->value);
        }
        // Return the payment details
        return $this->toArray($response['tran_ref'], $response['redirect_url']);
    }
}

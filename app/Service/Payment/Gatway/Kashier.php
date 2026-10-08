<?php

namespace App\Service\Payment\Gatway;

use App\Exceptions\PaymentException;
use App\Service\Enum\PaymentGatway;
use App\Service\Payment\PaymentGateway;
use App\Service\Payment\PaymentGatewayInterFace;

class Kashier extends PaymentGateway implements PaymentGatewayInterFace
{
    //datatype
    protected const DATATYPE_KASIHER = 'external';
    /**
     * The payment gateway to use for this request.
     *
     * @var string */
    protected $paymentGateway = PaymentGatway::KASHIER->value;
    /**
     * orderId
     *
     * @var mixed
     */
    protected $orderId;
    /**
     * Create Class construct
     *
     * @return void
     */
    public function __construct()
    {
        $this->orderId = time();
    }
    /**
     * CreateHash
     *
     * @param mixed $price
     *
     * @return mixed
     */
    private function createHash($price)
    {
        $amount = $price;
        // set order id
        $orderId = $this->orderId;
        // set path
        $path = "/?payment=" . env('KASHIER_MERCHANT_ID') . "." . $orderId . "." . $amount . "." . env('APP_CURRENCY');
        // set hash
        $hash = hash_hmac('sha256', $path, env('KASHIER_API_KEY'), false);
        // return hash
        return $hash;
    }
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
            'merchantId' => env('KASHIER_MERCHANT_ID'),
            'orderId' => $this->orderId,
            'amount' => $price,
            'currency' => env('APP_CURRENCY'),
            'hash' => $this->CreateHash($price),
            'mode' => env('KASHIER_MODE'),
            'merchantRedirect' => $returnUrl,
            'data-type' => self::DATATYPE_KASIHER
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
        $query = http_build_query($body);
        // Build the payment request
        $link = env('KASHIER_PAYMENT_LINK') . '?' . $query;
        // return array
        return $this->toArray($body['orderId'], $link);
    }
}

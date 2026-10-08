<?php

namespace App\Service\Payment\Gatway;

use App\Exceptions\PaymentException;
use App\Service\Enum\HttpStatusCode;
use App\Service\Enum\PaymentGatway;
use App\Service\Payment\PaymentGateway;
use App\Service\Payment\PaymentGatewayInterFace;

class Paymob extends PaymentGateway implements PaymentGatewayInterFace
{
    /**
     * The payment gateway to use for this request.
     *
     * @var string */
    protected $paymentGateway = PaymentGatway::PAYMOB->value;
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
            'amount' => (float) $price,
            'currency' => env('APP_CURRENCY'),
            'payment_methods' => [(int) env('PAYMOB_METHOD_FIRST'), (int) env('PAYMOB_METHOD_SECOUND')],
            'items' => [
                [
                    'name' => 'Item name',
                    'amount' => (float) $price,
                    "description" => "Item description",
                    "quantity" => 1
                ]
            ],
            'billing_data' => [
                "apartment" => "dumy",
                "first_name" => "ala",
                "last_name" => "zain",
                "street" => "dumy",
                "building" => "dumy",
                "phone_number" => "+92345xxxxxxxx",
                "city" => "dumy",
                "country" => "EG",
                "email" => "ali@gmail.com",
                "floor" => "dumy",
                "state" => "dumy"
            ],
            'notification_url' => $cancelUrl,
            'redirection_url' => $returnUrl
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
        $arr = $response['payment_keys'][0];
        // set key
        $key = $arr['key'];
        // set link
        $link = env('PAYMOB_URL') . '/api/acceptance/iframes/876673?payment_token=' . $key;
        // return array
        return $this->toArray($arr['order_id'], $link);
    }
}

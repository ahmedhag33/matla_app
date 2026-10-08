<?php

namespace App\Service\Payment\Gatway;

use App\Exceptions\PaymentException;
use App\Service\Enum\HttpStatusCode;
use App\Service\Enum\PaymentGatway;
use App\Service\Payment\PaymentGateway;
use App\Service\Payment\PaymentGatewayInterFace;

class MyFatoorah extends PaymentGateway implements PaymentGatewayInterFace
{
    protected const CURRENCY_KWT = 'kwd';
    // notification option
    protected const NOTIFICATIONOPTION = 'Lnk';
    /**
     * The payment gateway to use for this request.
     *
     * @var string */
    protected $paymentGateway = PaymentGatway::MY_FATOORAH->value;
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
            'NotificationOption' => self::NOTIFICATIONOPTION,
            'InvoiceValue' => $price,
            'CustomerName' => 'example',
            "CallBackUrl" => $returnUrl,
            "ErrorUrl" => $cancelUrl,
            "DisplayCurrencyIso" => self::CURRENCY_KWT,
            "Language" => app()->getLocale()
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
        return $this->toArray($response['Data']['InvoiceId'], $response['Data']['InvoiceURL']);
    }
}

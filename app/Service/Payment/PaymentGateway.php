<?php

namespace App\Service\Payment;

use App\Exceptions\PaymentException;
use App\Service\Base\ApiIntegration;
use App\Service\Enum\HttpStatusCode;
/**
 * Base contract for payment gateway integrations.
 * Subclasses implement provider-specific authorization, capture, and refund logic.
 */
abstract class PaymentGateway
{
    use ApiIntegration,
        BulidPaymentGateway;
    /**
     * Build the provider-specific payload for creating a payment request.
     *
     * @param float  $price     Amount to charge, in the gateway's currency.
     * @param string $returnUrl URL the provider redirects to after a successful payment.
     * @param string $cancelUrl URL the provider redirects to when the customer cancels.
     *
     * @return array<string, mixed> Request body sent to the payment provider.
     */
    abstract protected function requestModel(float $price, string $returnUrl, string $cancelUrl): array;
    /**
     * Serialize the gateway result for API responses.
     *
     * @param string $paymentId
     * @param string $paymentUrl
     *
     * @return array
     */
    protected function toArray(string $paymentId, string $paymentUrl): array
    {
        return [
            'paymentId' => $paymentId,
            'paymentUrl' => $paymentUrl,
        ];
    }
    /**
     * Build the provider-specific payload for creating a payment request.
     *
     * @param array $body
     *
     * @return array<string, mixed> Request body sent to the payment provider.
     */
    protected function buildPaymentRequest($body)
    {
        $response = $this->bulidRequest($this->requestMethodOfPayment(), $this->fullUrlToPayment(), $body, $this->header());
        // Check if the response is empty
        if (!$response) {
            throw new PaymentException('Payment failed', HttpStatusCode::BAD_REQUEST->value);
        }
        // Return the response
        return $response;
    }
}

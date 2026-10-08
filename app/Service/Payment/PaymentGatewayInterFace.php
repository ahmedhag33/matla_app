<?php

namespace App\Service\Payment;

use App\Exceptions\PaymentException;

interface PaymentGatewayInterFace
{
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
    public function paymentTransaction(float $price, string $returnUrl, $cancelUrl = '');
}

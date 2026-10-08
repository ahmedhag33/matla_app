<?php

namespace App\Service\Payment\PaymentClient;

use App\Service\Payment\PaymentGatewayInterFace;

class GatwayClient
{
    protected $paymentGateway;
    /**
     * create new payment client to use the payment gateway
     *
     * @param PaymentGatewayInterFace $paymentGateway
     *
     * @return void
     */
    public function __construct(PaymentGatewayInterFace $paymentGateway)
    {
        $this->paymentGateway = $paymentGateway;
    }
    /**
     * Initiate a payment with the provider and return the checkout details.
     *
     * @param float  $price     Amount to charge, in the gateway's currency.
     * @param string $returnUrl URL the provider redirects to after a successful payment.
     * @param string|null $cancelUrl URL the provider redirects to when the customer cancels.
     *
     * @return array
     */
    public function paymentTransaction(float $price, string $returnUrl, $cancelUrl = '')
    {
        return $this->paymentGateway->paymentTransaction($price, $returnUrl, $cancelUrl ?? null);
    }
}

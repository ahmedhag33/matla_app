<?php

namespace Tests\Feature\Payment;

use App\Service\Payment\Gatway\Kashier;
use App\Service\Payment\Gatway\MyFatoorah;
use App\Service\Payment\Gatway\Paymob;
use App\Service\Payment\Gatway\PayTab;
use Tests\TestCase;

class PaymentGatewayTest extends TestCase
{
    /**
     * test my fatoorah payment is asserted created
     */
    public function test_my_fatoorah_payment_is_asserted_created()
    {
        $payment = new MyFatoorah();
        // Make the payment
        $data = $payment->paymentTransaction(200, 'https://www.google.com/', 'https://www.google.com/');
        // Assert that the payment was created
        $this->assertArrayHasKey('paymentId', $data);
        // Assert that the invoice URL was created
        $this->assertArrayHasKey('paymentUrl', $data);
    }
    /**
     * test paytab payment is asserted created
     */
    public function test_paytab_payment_is_asserted_created()
    {
        $payment = new PayTab();
        // Make the payment
        $data = $payment->paymentTransaction(200, 'https://www.google.com/');
        // Assert that the payment was created
        $this->assertArrayHasKey('paymentId', $data);
        // Assert that the invoice URL was created
        $this->assertArrayHasKey('paymentUrl', $data);
    }
    /**
     * test kashier payment is asserted created
     */
    public function test_kashier_payment_is_asserted_created()
    {
        $payment = new Kashier();
        // Make the payment
        $data = $payment->paymentTransaction(200, 'https://www.google.com/');
        // Assert that the payment was created
        $this->assertArrayHasKey('paymentId', $data);
        // Assert that the invoice URL was created
        $this->assertArrayHasKey('paymentUrl', $data);
    }
    /**
     * test paymob payment is asserted created
     */
    public function test_paymob_payment_is_asserted_created()
    {
        $payment = new Paymob();
        // Make the payment
        $data = $payment->paymentTransaction(200, 'https://www.google.com/', 'https://www.google.com/');
        // Assert that the payment was created
        $this->assertArrayHasKey('paymentId', $data);
        // Assert that the invoice URL was created
        $this->assertArrayHasKey('paymentUrl', $data);
    }
}

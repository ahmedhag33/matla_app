<?php

namespace App\Service\Payment;

use App\Exceptions\PaymentException;
use App\Service\Enum\HttpStatusCode;
use Illuminate\Support\Facades\Config;

trait BulidPaymentGateway
{
    /**
     * get Payment Gatway info config file payment
     *
     * @return string
     */
    protected function getPaymentGatway()
    {
        return property_exists($this, 'paymentGateway') ? $this->paymentGateway : null;
    }
    /**
     * get Payment Gatway info config file payment
     *
     * @return array
     * @throws PaymentException
     */
    protected function paymentGatway()
    {
        // check if payment config file exist
        if (!file_exists(config_path('payment.php'))) {
            throw new PaymentException('Payment config file not found', HttpStatusCode::NOT_FOUND->value);
        }
        // check if payment configration exist
        if (!Config::has('payment')) {
            throw new PaymentException("Payment configration not found", HttpStatusCode::NOT_FOUND->value);
        }
        // check if payment gatway exist
        if (!Config::has('payment.' . $this->getPaymentGatway())) {
            throw new PaymentException('Payment Gatway' . $this->getPaymentGatway() . 'not found', HttpStatusCode::NOT_FOUND->value);
        }
        // return payment gatway
        return config('payment.' . $this->getPaymentGatway());
    }
    /**
     * get Payment Gatway header
     *
     * @return array
     * @throws PaymentException
     */
    protected function header()
    {
        // check if payment gatway header exist
        if (!array_key_exists('header', $this->paymentGatway())) {
            throw new PaymentException('Payment Gatway header not found', HttpStatusCode::BAD_REQUEST->value);
        }
        // return payment gatway
        return $this->paymentGatway()['header'];
    }
    /**
     * get Payment Gatway url
     *
     * @return array
     * @throws PaymentException
     */
    protected function url()
    {
        if (!array_key_exists('url', $this->paymentGatway())) {
            throw new PaymentException('Payment Gatway url not found', HttpStatusCode::BAD_REQUEST->value);
        }
        return $this->paymentGatway()['url'];
    }
    /**
     * get Payment Gatway payment
     *
     * @return array
     * @throws PaymentException
     */
    protected function payment()
    {
        if (!array_key_exists('payment', $this->paymentGatway())) {
            throw new PaymentException('Payment Gatway payment not found', HttpStatusCode::BAD_REQUEST->value);
        }
        return $this->paymentGatway()['payment'];
    }
    /**
     * get Payment Gatway paymentStatus
     *
     * @return array
     * @throws PaymentException
     */
    protected function paymentStatus()
    {
        if (!array_key_exists('paymentstatus', $this->paymentGatway())) {
            throw new PaymentException('Payment Gatway paymentProcess not found', HttpStatusCode::BAD_REQUEST->value);
        }
        return $this->paymentGatway()['paymentstatus'];
    }
    /**
     * get Payment Gatway paymentStatus
     *
     * @return array
     * @throws PaymentException
     */
    protected function requestMethodOfPayment()
    {
        if (!array_key_exists('request_method', $this->payment())) {
            throw new PaymentException('Payment Gatway request_method not found', HttpStatusCode::BAD_REQUEST->value);
        }
        return $this->payment()['request_method'];
    }
    /**
     * get url of Payment Gatway
     *
     * @return array
     * @throws PaymentException
     */
    protected function urlPayment()
    {
        if (!array_key_exists('link', $this->payment())) {
            throw new PaymentException('Payment Gatway link not found', HttpStatusCode::BAD_REQUEST->value);
        }
        return $this->payment()['link'];
    }
    /**
     * get full url of Payment Gatway
     *
     * @return string
     */
    protected function fullUrlToPayment()
    {
        return $this->url() . $this->urlPayment();
    }
    /**
     * get Payment Gatway paymentStatus
     *
     * @return array
     * @throws PaymentException
     */
    protected function requestMethodOfPaymentStatus()
    {
        if (!array_key_exists('request_method', $this->paymentStatus())) {
            throw new PaymentException('Payment Gatway request_method not found', HttpStatusCode::BAD_REQUEST->value);
        }
        return $this->paymentStatus()['request_method'];
    }
    /**
     * get url of Payment Gatway
     *
     * @return array
     * @throws PaymentException
     */
    protected function urlPaymentStatus()
    {
        if (!array_key_exists('link', $this->paymentStatus())) {
            throw new PaymentException('Payment Gatway link not found', HttpStatusCode::BAD_REQUEST->value);
        }
        return $this->paymentStatus()['link'];
    }
    /**
     * get full url of Payment Gatway
     *
     * @return string
     */
    protected function fullUrlToPaymentStatus()
    {
        return $this->url() . $this->urlPaymentStatus();
    }
}

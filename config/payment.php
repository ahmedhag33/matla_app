<?php

use App\Service\Enum\AuthorizationScheme;
use App\Service\Enum\ContentType;
use App\Service\Enum\PaymentGatway;
use App\Service\Enum\RequestMethod;

return [
        /*
        |--------------------------------------------------------------------------
        | Payment Gateways
        |--------------------------------------------------------------------------
        |
        | This file is for storing the credentials for third party services such
        | as Stripe, Mailgun, SparkPost and others. This file provides a sane
        | default location for this type of information, allowing packages
        | to have a conventional place to find your various credentials.
        |
        */
        /**
         * payment gateways info myfatorah
         */
    PaymentGatway::MY_FATOORAH->value => [
        'photo' => 'myfatorah.svg',
        'url' => env('MYFATORAH_URL'),
        'header' => [
            'Content-Type' => ContentType::JSON->value,
            'Authorization' => AuthorizationScheme::BEARER->value . ' ' . env('MYFATORAH_TOKEN')
        ],
        'payment' => [
            'request_method' => RequestMethod::POST->value,
            'link' => '/v2/SendPayment'
        ],
        'paymentstatus' => [
            'request_method' => RequestMethod::POST->value,
            'link' => '/v2/getPaymentStatus'
        ],
        'active' => env('MYFATORAH_ACTIVE')
    ],
        /*
         * payment gateways info paytab
         */
    PaymentGatway::PAYTAB->value => [
        'photo' => '34-340551_paytabs-hd-png-download.png',
        'url' => env('PAYTAB_URL'),
        'header' => [
            'Content-Type' => ContentType::JSON->value,
            'Authorization' => env('PAYTAB_TOKEN')
        ],
        'payment' => [
            'request_method' => RequestMethod::POST->value,
            'link' => '/payment/request'
        ],
        'paymentstatus' => [
            'request_method' => null,
            'link' => null
        ],
        'active' => env('PAYTAB_ACTIVE')
    ],
        /**
         * payment gateways info kashier
         */
    PaymentGatway::KASHIER->value => [
        'photo' => 'kashier-logo.png',
        'url' => env('KASHIER_URL'),
        'header' => [
            'Content-Type' => null,
            'Authorization' => null
        ],
        'payment' => [
            'request_method' => null,
            'link' => null
        ],
        'paymentstatus' => [
            'request_method' => RequestMethod::GET->value,
            'link' => '/payments/orders'
        ],
        'active' => env('KASHIER_ACTIVE')
    ],
    PaymentGatway::PAYMOB->value => [
        'photo' => 'PayMob_Payments.png',
        'url' => env('PAYMOB_URL'),
        'header' => [
            'Content-Type' => ContentType::JSON->value,
            'Authorization' => AuthorizationScheme::TOKEN->value . ' ' . env('PAYMOB_TOKEN')
        ],
        'payment' => [
            'request_method' => RequestMethod::POST->value,
            'link' => '/v1/intention'
        ],
        'paymentstatus' => [
            'request_method' => null,
            'link' => null
        ],
        'active' => env('PAYMOB_ACTIVE')
    ],
];

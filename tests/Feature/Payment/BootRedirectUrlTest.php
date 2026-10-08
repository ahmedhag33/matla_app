<?php

namespace Tests\Feature\Payment;

use App\Exceptions\PaymentException;
use App\Service\Enum\HttpStatusCode;
use App\Service\Payment\Gatway\Kashier;
use App\Service\Payment\Gatway\MyFatoorah;
use App\Service\Payment\Gatway\Paymob;
use App\Service\Payment\Gatway\PayTab;
use App\Service\Payment\PaymentClient\PaymentRedirectProvider;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class BootRedirectUrlTest extends TestCase
{
    /**
     * test it returns the registered redirect url.
     */
    public function test_it_returns_the_registered_redirect_url()
    {
        $this->assertSame(
            'https://example.com/order/callback',
            PaymentRedirectProvider::bootredirectUrl(MyFatoorah::class, 'order')
        );
    }
    /**
     * test it throws when the gateway is not registered.
     */
    public function test_it_throws_when_the_gateway_is_not_registered()
    {
        // set expectation
        $this->expectException(PaymentException::class);
        // set expectation
        $this->expectExceptionMessageIs('Payment service [App\\Payment\\Gateway\\Unknown] is not registered');
        // set expectation
        $this->expectExceptionCode(HttpStatusCode::NOT_FOUND->value);
        // set the gateway to the one under test
        PaymentRedirectProvider::bootredirectUrl('App\\Payment\\Gateway\\Unknown', 'order');
    }
    /**
     * test it throws when the action type is not registered.
     */
    public function test_it_throws_when_the_action_type_is_not_registered()
    {
        // set expectation
        $this->expectException(PaymentException::class);
        // set expectation
        $this->expectExceptionMessageIs("No redirect url registered for [" . MyFatoorah::class . "] with action type [subscription]");
        // set expectation
        $this->expectExceptionCode(HttpStatusCode::NOT_FOUND->value);
        // set the gateway to the one under test
        PaymentRedirectProvider::bootredirectUrl(MyFatoorah::class, 'subscription');
    }
    #[DataProvider('registeredGateways')]
    /**
     * test every registered gateway resolves both action types.
     */
    public function test_every_registered_gateway_resolves_both_action_types(string $gateway)
    {
        foreach (['order', 'wallet'] as $actionType) {
            $this->assertNotEmpty(
                PaymentRedirectProvider::bootredirectUrl($gateway, $actionType)
            );
        }
    }
    public static function registeredGateways(): array
    {
        return [
            [MyFatoorah::class],
            [PayTab::class],
            [Kashier::class],
            [Paymob::class],
        ];
    }
}

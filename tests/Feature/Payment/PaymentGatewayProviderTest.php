<?php

namespace Tests\Feature\Payment;

use App\Exceptions\PaymentException;
use App\Service\Enum\HttpStatusCode;
use App\Service\Enum\PaymentGatway;
use App\Service\Payment\Provider\PaymentGatewayProvider;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class PaymentGatewayProviderTest extends TestCase
{
    /**
     * test register provider not empty
     */
    public function test_register_provider_not_empty(): void
    {
        $provider = new class () extends PaymentGatewayProvider {
            public function getRegisteredProviders(): array
            {
                return $this->getRegisted();
            }
        };
        $this->assertNotEmpty($provider->getRegisteredProviders());
    }
    /**
     * test all payment services throws is not exist
     */
    public function test_all_payment_services_throws_is_not_exist()
    {
        $this->expectException(PaymentException::class);
        // set the gateway to the one under test
        $this->expectExceptionMessageIs('Payment service [stripe] is not registered');
        // set the gateway to the one under test
        $this->expectExceptionCode(HttpStatusCode::NOT_FOUND->value);
        // set the gateway to the one under test
        new PaymentGatewayProvider()->service('stripe', 100);
    }
    /**
     * test all classes of payment services throws is not exist
     */
    public function test_all_classes_of_payment_services_throws_is_not_exist()
    {
        $this->expectException(PaymentException::class);
        // set the gateway to the one under test
        $this->expectExceptionMessageIs('Class Of Payment [stripe] is not registered');
        // set the gateway to the one under test
        $this->expectExceptionCode(HttpStatusCode::NOT_FOUND->value);
        // set the gateway to the one under test
        $service = new class extends PaymentGatewayProvider {
            protected array $registed = [
                'stripe' => 'App\Service\Payment\Gateway\Stripe',
            ];
        };
        // set the gateway to the one under test
        $service->service('stripe', 100);
    }
    #[DataProvider('transferPaymentGateways')]
    /**
     * test all payment gateway
     */
    public function test_all_payment_gateway(string $gateway): void
    {
        $service = new class extends PaymentGatewayProvider {
            protected string $actionType = 'order';
        };
        $data = $service->service($gateway, 100);
        // Assert that the payment was created
        $this->assertArrayHasKey('cashId', $data);
        // Assert that the payment was created
        $this->assertArrayHasKey('paymentId', $data);
        // Assert that the invoice URL was created
        $this->assertArrayHasKey('paymentUrl', $data);
    }
    /**
     * test all payment gateway
     */
    public static function transferPaymentGateways()
    {
        return [
            [PaymentGatway::KASHIER->value],
            [PaymentGatway::MY_FATOORAH->value],
            [PaymentGatway::PAYMOB->value],
            [PaymentGatway::PAYTAB->value],
        ];
    }
}

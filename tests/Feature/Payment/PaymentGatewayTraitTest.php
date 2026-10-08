<?php

namespace Tests\Feature\Payment;

use App\Exceptions\PaymentException;
use App\Service\Enum\AuthorizationScheme;
use App\Service\Enum\ContentType;
use App\Service\Enum\PaymentGatway;
use App\Service\Enum\RequestMethod;
use App\Service\Payment\BulidPaymentGateway;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;
/**
 * NOTE ON ASSUMPTIONS (please adjust to match your real code):
 *
 * 1. The methods under test live in a TRAIT (assumed name: PaymentGatewayTrait,
 *    assumed namespace: App\Traits\PaymentGatewayTrait). If they actually live
 *    directly on a class, replace the anonymous "use trait" class below with
 *    `new class extends YourRealClass { ... }`.
 * 2. The host class exposes a settable `paymentGateway` property, whose value
 *    is one of the `PaymentGatway` enum cases (e.g. PaymentGatway::MY_FATOORAH),
 *    used as the config key under `config/payment.php`.
 * 3. `PaymentException::getCode()` returns the HttpStatusCode value passed in.
 * 4. The config array shape mirrors your real `payment.php`: top-level
 *    `photo`, `url`, `header`, `payment`, `paymentstatus`, `active` keys.
 */
class PaymentGatewayTraitTest extends TestCase
{
    /**
     * The gateway key under test — matches a real case in your PaymentGatway enum.
     * */
    protected const PAYMENT_GATEWAY = PaymentGatway::MY_FATOORAH->value;
    /**
     * setup the test case by setting the gateway to the one under test
     *
     * @return void
     * */
    protected function teardown(): void
    {
        Config::clearResolvedInstance('payment');
        // set back to default
        parent::tearDown();
    }
    /**
     * Build a concrete, testable instance that exposes the trait's
     * protected methods as public ones.
     *
     * @return object
     */
    protected function makeSubject(string $gateway = self::PAYMENT_GATEWAY)
    {
        return new class ($gateway) {
            use BulidPaymentGateway;
            /**
             * @var string
             * */
            protected $paymentGateway;
            /**
             * @param string $gateway
             * */
            public function __construct(string $gateway)
            {
                $this->paymentGateway = $gateway;
            }
            // Public wrappers so the test can call the protected trait methods.
            public function callGetPaymentGatway()
            {
                return $this->getPaymentGatway(); }
            public function callPaymentGatway()
            {
                return $this->paymentGatway(); }
            public function callHeader()
            {
                return $this->header(); }
            public function callUrl()
            {
                return $this->url(); }
            public function callPayment()
            {
                return $this->payment(); }
            public function callPaymentStatus()
            {
                return $this->paymentStatus(); }
            public function callRequestMethodOfPayment()
            {
                return $this->requestMethodOfPayment(); }
            public function callUrlPayment()
            {
                return $this->urlPayment(); }
            public function callRequestMethodOfPaymentStatus()
            {
                return $this->requestMethodOfPaymentStatus(); }
            public function callUrlPaymentStatus()
            {
                return $this->urlPaymentStatus(); }
        };
    }
    /**
     * get full valid config
     *
     * @return array
     * */
    protected function fullValidConfig()
    {
        return
            [
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
            ];
    }
    /**
     * payment_gatway_returns_the_configured_gateway_name
     * */
    public function test_payment_gatway_returns_the_configured_gateway_name()
    {
        $subject = $this->makeSubject(self::PAYMENT_GATEWAY);
        // set the gateway to the one under test
        $this->assertEquals(self::PAYMENT_GATEWAY, $subject->callGetPaymentGatway());
    }
    /**
     * @test payment_gatway_returns_null_when_property_not_set
     * */
    public function test_payment_gatway_returns_null_when_property_not_set()
    {
        $subject = $this->makeSubject();
        // set the gateway to the one under test
        $this->assertNotNull($subject->callPaymentGatway());
    }
    /**
     * gatway_throws_when_payment_config_not_registered
     * */
    public function test_gatway_throws_when_payment_config_not_registered()
    {
        Config::shouldReceive('has')->once()->with('payment')->andReturn(false);
        // set the gateway to the one under test
        $subject = $this->makeSubject();
        // set the gateway to the one under test
        $this->expectException(PaymentException::class);
        // set the gateway to the one under test
        $this->expectExceptionMessageIs('Payment configration not found');
        // set the gateway to the one under test
        $subject->callPaymentGatway();
    }
    /**
     * gatway_throws_when_specific_gateway_not_found
     * */
    public function test_gatway_throws_when_specific_gateway_not_found()
    {
        Config::shouldReceive('has')->once()->with('payment')->andReturn(true);
        // set the gateway to the one under test
        Config::shouldReceive('has')->once()->with('payment.' . self::PAYMENT_GATEWAY)->andReturn(false);
        // set subject to the one under test
        $subject = $this->makeSubject();
        // set the gateway to the one under test
        $this->expectException(PaymentException::class);
        // set the gateway to the one under test
        $this->expectExceptionMessageIs('Payment Gatway' . self::PAYMENT_GATEWAY . 'not found');
        // set the gateway to the one under test
        $subject->callPaymentGatway();
    }
    /**
     * payment_gatway_returns_config_array_when_everything_present
     * */
    public function test_payment_gatway_returns_config_array_when_everything_present()
    {
        $subject = $this->makeSubject(self::PAYMENT_GATEWAY);
        // set the gateway to the one under test
        $this->assertEquals($this->fullValidConfig(), $subject->callPaymentGatway());
    }
    /**
     * header_returns_header_array_when_present
     * */
    public function test_header_returns_header_array_when_present()
    {
        $subject = $this->makeSubject(self::PAYMENT_GATEWAY);
        // set the gateway to the one under test
        $this->assertEquals($this->fullValidConfig()['header'], $subject->callHeader());
    }
    /**
     * header_throws_when_missing_from_config
     * */
    public function test_header_throws_when_missing_from_config()
    {
        $config = $this->fullValidConfig();
        // set the gateway to the one under test
        unset($config['header']);
        // set the gateway to the one under test
        config([
            'payment.' . self::PAYMENT_GATEWAY => $config
        ]);
        // set the gateway to the one under test
        $subject = $this->makeSubject();
        // set the gateway to the one under test
        $this->expectException(PaymentException::class);
        // set the gateway to the one under test
        $this->expectExceptionMessageIs('Payment Gatway header not found');
        // set the gateway to the one under test
        $subject->callHeader();
    }
    /**
     * url_returns_value_when_present
     * */
    public function test_url_returns_value_when_present()
    {
        $subject = $this->makeSubject();
        // set the gateway to the one under test
        $this->assertEquals($this->fullValidConfig()['url'], $subject->callUrl());
    }
    /**
     * url_throws_when_missing_from_config
     * */
    public function test_url_throws_when_missing_from_config()
    {
        $config = $this->fullValidConfig();
        // set the gateway to the one under test
        unset($config['url']);
        // set the gateway to the one under test
        config([
            'payment.' . self::PAYMENT_GATEWAY => $config
        ]);
        // set the gateway to the one under test
        $subject = $this->makeSubject();
        // set the gateway to the one under test
        $this->expectException(PaymentException::class);
        // set the gateway to the one under test
        $this->expectExceptionMessageIs('Payment Gatway url not found');
        // set the gateway to the one under test
        $subject->callUrl();
    }
    /**
     * payment_returns_value_when_present
     * */
    public function test_payment_returns_value_when_present()
    {
        $subject = $this->makeSubject();
        // set the gateway to the one under test
        $this->assertEquals($this->fullValidConfig()['payment'], $subject->callPayment());
    }
    /**
     * payment_throws_when_missing_from_config
     * */
    public function test_payment_throws_when_missing_from_config()
    {
        $config = $this->fullValidConfig();
        // set the gateway to the one under test
        unset($config['payment']);
        // set the gateway to the one under test
        config([
            'payment.' . self::PAYMENT_GATEWAY => $config
        ]);
        // set the gateway to the one under test
        $subject = $this->makeSubject();
        // set the gateway to the one under test
        $this->expectException(PaymentException::class);
        // set the gateway to the one under test
        $this->expectExceptionMessageIs('Payment Gatway payment not found');
        // set the gateway to the one under test
        $subject->callPayment();
    }
}

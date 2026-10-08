<?php

namespace App\Service\Payment\Provider;

use App\Exceptions\PaymentException;
use App\Service\Base\CustomProvider;
use App\Service\Enum\HttpStatusCode;
use App\Service\Enum\PaymentGatway;
use App\Service\Payment\Gatway\Kashier;
use App\Service\Payment\Gatway\MyFatoorah;
use App\Service\Payment\Gatway\Paymob;
use App\Service\Payment\Gatway\PayTab;
use App\Service\Payment\PaymentClient\GatwayClient;
use App\Service\Payment\PaymentClient\PaymentRedirectProvider;

class PaymentGatewayProvider extends CustomProvider
{
    /**
     * Map of supported payment gateways, keyed by the gateway identifier
     * stored in requests/config (the PaymentGatway enum value) and pointing
     * at the concrete gateway class that handles it.
     *
     * Used to resolve a gateway implementation at runtime, e.g.
     * `new $this->registred[$request->gateway]`. Add an enum case here
     * together with its class whenever a new gateway is integrated.
     *
     * @var array<string, class-string>
     */
    protected array $registed = [
            // MyFatoorah gateway (Kuwait/GCC) handler
        PaymentGatway::MY_FATOORAH->value => MyFatoorah::class,
            // PayTabs gateway handler
        PaymentGatway::PAYTAB->value => PayTab::class,
            // Kashier gateway (Egypt) handler
        PaymentGatway::KASHIER->value => Kashier::class,
            // Paymob gateway (Egypt) handler
        PaymentGatway::PAYMOB->value => Paymob::class,
    ];
    /**
     * The action the payment belongs to — e.g. "order" or "wallet".
     *
     * Guarded by a property hook: assignment is validated, so the property can
     * never hold an empty value once set. Reads return the backing value as-is.
     *
     * @throws PaymentException on assignment of an empty value (400 Bad Request)
     */
    protected string $actionType = '' {
        set {
            /**
             * Validate and store the action type.
             *
             * @param string $value the action type being assigned
             * @throws PaymentException if no action type was supplied
             */
            if (empty($value)) {
                throw new PaymentException('Action type is required', HttpStatusCode::BAD_REQUEST->value);
            }
            // Writing $this->actionType inside the hook targets the backing
            // field, so this does not re-enter the setter.
            $this->actionType = $value;
        }
        get {
            /**
             * @return string the stored action type
             */
            return $this->actionType;
        }
    }
    /**
     * Start a payment transaction on the given gateway.
     *
     * Resolves the gateway class from the registry, boots it behind the
     * generic gateway client, initiates the transaction for the given amount,
     * and returns the gateway response enriched with the current cash id.
     *
     * @param string    $service the gateway identifier (a PaymentGatway enum value)
     * @param int|float $price   the amount to charge
     *
     * @return array the gateway transaction payload, plus a `cash_id` entry
     *
     * @throws PaymentException if the gateway is not registered (404) or its class is missing (404)
     */
    public function service($service, $price)
    {
        // reject identifiers that have no entry in the gateway registry
        if (!array_key_exists($service, $this->registed)) {
            throw new PaymentException("Payment service [{$service}] is not registered", HttpStatusCode::NOT_FOUND->value);
        }
        // cash register the payment is attributed to; merged into the response below
        $cashArr = ['cashId' => PaymentRedirectProvider::getCashID()];
        // resolve the concrete gateway class name for this identifier
        $boot = $this->boot($service);
        // guard against a registry entry pointing at a class that no longer exists
        if (!class_exists($boot)) {
            throw new PaymentException("Class Of Payment [{$service}] is not registered", HttpStatusCode::NOT_FOUND->value);
        }
        // wrap the gateway driver in the common client interface
        $paymentClient = new GatwayClient(new $boot);
        // initiate the transaction, passing the success/failure redirect urls
        $data = $paymentClient->paymentTransaction(
            $price,
            PaymentRedirectProvider::bootredirectUrl($boot, $this->actionType),
            PaymentRedirectProvider::bootcancelUrl($boot, $this->actionType)
        );
        // expose the cash id alongside the gateway payload
        return array_merge($cashArr, $data);
    }
}

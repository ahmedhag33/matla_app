<?php

namespace App\Service\Payment\PaymentClient;

use App\Exceptions\PaymentException;
use App\Service\Enum\HttpStatusCode;
use App\Service\Payment\Gatway\Kashier;
use App\Service\Payment\Gatway\MyFatoorah;
use App\Service\Payment\Gatway\Paymob;
use App\Service\Payment\Gatway\PayTab;

class PaymentRedirectProvider
{
    /**
     * Globally shared cash register (drawer) identifier for the current request.
     *
     * Backed by a property hook: reads/writes go through the accessors below
     * rather than touching the raw static value directly.
     *
     * @var string
     */
    protected static $cashId;
    /**
     * Return the cash id used for payment
     *
     * @return string|int|null the cash id
     */
    public static function getCashID()
    {
        return self::$cashId ?? str()->uuid();
    }
    /**
     * Return the redirect url for payment gateway after payment is done
     *
     * @param string $class payment gateway class
     * @param string $actiontype order or wallet
     *
     * @return string the redirect url
     * @throws PaymentException
     */
    public static function bootredirectUrl($class, $actiontype)
    {
        $url = self::registerRedirectUrl();
        // check if payment gateway exist
        if (!in_array($class, array_keys($url))) {
            throw new PaymentException("Payment service [{$class}] is not registered", HttpStatusCode::NOT_FOUND->value);
        }
        // check if redirect url exist
        if (!array_key_exists($actiontype, $url[$class]) || empty($url[$class][$actiontype])) {
            throw new PaymentException(
                "No redirect url registered for [{$class}] with action type [{$actiontype}]",
                HttpStatusCode::NOT_FOUND->value
            );
        }
        return $url[$class][$actiontype];
    }
     /**
     * Return the redirect url for payment gateway after payment is done
     *
     * @param string $class payment gateway class
     * @param string $actiontype order or wallet
     *
     * @return string the redirect url
     * @throws PaymentException
     */
    public static function bootcancelUrl($class, $actiontype)
    {
        $url = self::registerCancelUrl();
        // check if payment gateway exist
        if (!in_array($class, array_keys($url))) {
            throw new PaymentException("Payment service [{$class}] is not registered", HttpStatusCode::NOT_FOUND->value);
        }
        // check if redirect url exist
        if (!array_key_exists($actiontype, $url[$class]) || empty($url[$class][$actiontype])) {
            throw new PaymentException(
                "No cancel url registered for [{$class}] with action type [{$actiontype}]",
                HttpStatusCode::NOT_FOUND->value
            );
        }
        return $url[$class][$actiontype];
    }
    /**
     * Return an array of redirect urls for payment gateways after payment is done
     *
     * The array is indexed by the payment gateway class name and the action type
     * (order or wallet)
     *
     * @return array an array of redirect urls
     */
    protected static function registerRedirectUrl()
    {
        return [
                // set redirect url for each payment gateway class (myfatoorah)
            MyFatoorah::class => [
                'order' => self::redirectUrl('/order/callback'),
                'wallet' => self::redirectUrl('/wallet/callback'),
            ],
                // set redirect url for each payment gateway class (paytab)
            PayTab::class => [
                'order' => self::redirectUrl('/order/callback'),
                'wallet' => self::redirectUrl('/wallet/callback'),
            ],
                // set redirect url for each payment gateway class (kashier)
            Kashier::class => [
                'order' => self::redirectUrl('/order/callback'),
                'wallet' => self::redirectUrl('/wallet/callback'),
            ],
                // set redirect url for each payment gateway class (paymob)
            Paymob::class => [
                'order' => self::redirectUrl('/order/callback'),
                'wallet' => self::redirectUrl('/wallet/callback'),
            ],
        ];
    }
     /**
     * Return an array of redirect urls for payment gateways after payment is cancel
     *
     * The array is indexed by the payment gateway class name and the action type
     * (order or wallet)
     *
     * @return array an array of redirect urls
     */
    protected static function registerCancelUrl()
    {
        return [
                // set redirect url for each payment gateway class (myfatoorah)
            MyFatoorah::class => [
                'order' => self::redirectUrl('/order/cancel'),
                'wallet' => self::redirectUrl('/wallet/cancel'),
            ],
                // set redirect url for each payment gateway class (paytab)
            PayTab::class => [
                'order' => self::redirectUrl('/order/cancel'),
                'wallet' => self::redirectUrl('/wallet/cancel'),
            ],
                // set redirect url for each payment gateway class (kashier)
            Kashier::class => [
                'order' => self::redirectUrl('/order/cancel'),
                'wallet' => self::redirectUrl('/wallet/cancel'),
            ],
                // set redirect url for each payment gateway class (paymob)
            Paymob::class => [
                'order' => self::redirectUrl('/order/cancel'),
                'wallet' => self::redirectUrl('/wallet/cancel'),
            ],
        ];
    }
    /**
     * Return the full url of the given route
     *
     * The full url is the APP_URL plus the given route plus the cash id
     *
     * @param string $route the route to get the full url for
     * @return string the full url
     */
    protected static function redirectUrl($route)
    {
        return env('APP_URL') . $route . self::$cashId;
    }
}

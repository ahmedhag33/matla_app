<?php

namespace App\Service\Base;

use App\Service\Base\JsonAPIMessages;
use App\Service\Enum\HttpStatusCode;

abstract class CustomProvider
{
    use JsonAPIMessages;
    /**
     *  The registered custom providers
     *
     * @var array
     */
    protected array $registed = [];
    /**
     * Get the registered custom providers
     *
     * @return array
     */
    protected function getRegisted()
    {
        return $this->registed;
    }
    /**
     * Boot the provider and return the service instance
     *
     * @param string $serviceProvider
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function boot($serviceProvider)
    {
        try {
            // check if the provider is registered
            if (!array_key_exists($serviceProvider, $this->getRegisted())) {
                throw new \InvalidArgumentException('Provider not found', HttpStatusCode::BAD_REQUEST->value);
            }
            // get the service
            $service = $this->getRegisted()[$serviceProvider];
            // boot the service
            return $service;
        } catch (\InvalidArgumentException $e) {
            return $this->errorException($e->getCode(), $e->getMessage());
        }
    }
}

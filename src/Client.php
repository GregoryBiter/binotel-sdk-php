<?php

namespace Binotel\Sdk;

use Binotel\Sdk\Http\CurlHttpClient;
use Binotel\Sdk\Http\HttpClientInterface;
use Binotel\Sdk\Services\Calls;
use Binotel\Sdk\Services\Customers;
use Binotel\Sdk\Services\Settings;
use Binotel\Sdk\Services\Stats;

/**
 * @property-read Calls $calls
 * @property-read Stats $stats
 * @property-read Customers $customers
 * @property-read Settings $settings
 */
class Client
{
    private Config $config;
    private HttpClientInterface $httpClient;
    private array $services = [];

    public function __construct(
        string $key,
        string $secret,
        ?HttpClientInterface $httpClient = null,
        ?Config $config = null
    ) {
        $this->config = $config ?? new Config($key, $secret);
        $this->httpClient = $httpClient ?? new CurlHttpClient();
    }

    public function __get(string $name)
    {
        $serviceClass = match ($name) {
            'calls' => Calls::class,
            'stats' => Stats::class,
            'customers' => Customers::class,
            'settings' => Settings::class,
            default => null
        };

        if ($serviceClass) {
            if (!isset($this->services[$name])) {
                $this->services[$name] = new $serviceClass($this->config, $this->httpClient);
            }
            return $this->services[$name];
        }

        trigger_error('Undefined property via __get(): ' . $name, E_USER_NOTICE);
        return null;
    }

    public function getConfig(): Config
    {
        return $this->config;
    }

    public function getHttpClient(): HttpClientInterface
    {
        return $this->httpClient;
    }
}

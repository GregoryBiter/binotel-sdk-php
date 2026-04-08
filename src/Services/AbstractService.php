<?php

namespace Binotel\Sdk\Services;

use Binotel\Sdk\Config;
use Binotel\Sdk\Http\HttpClientInterface;

abstract class AbstractService
{
    public function __construct(
        protected readonly Config $config,
        protected readonly HttpClientInterface $httpClient
    ) {
    }

    protected function request(string $method, array $params = []): array
    {
        $params['key'] = $this->config->key;
        $params['secret'] = $this->config->secret;

        $url = $this->config->getBaseUrl() . $method . '.' . $this->config->apiFormat;

        return $this->httpClient->post($url, $params);
    }
}

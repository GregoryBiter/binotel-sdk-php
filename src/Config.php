<?php

namespace Binotel\Sdk;

class Config
{
    public function __construct(
        public readonly string $key,
        public readonly string $secret,
        public readonly string $apiHost = 'https://api.binotel.com/api/',
        public readonly string $apiVersion = '4.0',
        public readonly string $apiFormat = 'json'
    ) {
    }

    public function getBaseUrl(): string
    {
        return rtrim($this->apiHost, '/') . '/' . $this->apiVersion . '/';
    }
}

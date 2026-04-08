<?php

namespace Binotel\Sdk\Http;

interface HttpClientInterface
{
    public function post(string $url, array $params): array;
}

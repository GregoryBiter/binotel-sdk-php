<?php

namespace Binotel\Sdk\Http;

use Binotel\Sdk\Exceptions\ApiResponseException;

class CurlHttpClient implements HttpClientInterface
{
    private $disableSSLChecks = false;

    public function post(string $url, array $params): array
    {
        $postData = json_encode($params);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Length: ' . strlen($postData),
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if ($this->disableSSLChecks) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }

        $result = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $error = curl_error($ch);
        curl_close($ch);

        if ($error) {
            throw new ApiResponseException("CURL Error: $error");
        }

        if ($code !== 200) {
            throw new ApiResponseException("HTTP Error: $code", $code, json_decode($result, true));
        }

        $decodeResult = json_decode($result, true);

        if ($decodeResult === null) {
            throw new ApiResponseException("Invalid JSON response: $result");
        }

        if (isset($decodeResult['status']) && $decodeResult['status'] === 'error') {
            $message = $decodeResult['message'] ?? 'Unknown API error';
            $apiCode = $decodeResult['code'] ?? 0;
            throw new ApiResponseException("API Error ($apiCode): $message", (int)$apiCode, $decodeResult);
        }

        return $decodeResult;
    }

    public function disableSSLChecks(): void
    {
        $this->disableSSLChecks = true;
    }
}

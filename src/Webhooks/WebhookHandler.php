<?php

namespace Binotel\Sdk\Webhooks;

class WebhookHandler
{
    /**
     * List of Binotel server IPs as provided in the samples.
     */
    public const BINOTEL_IPS = [
        '194.88.218.116', '194.88.218.114', '194.88.218.117', '194.88.218.118',
        '194.88.219.67', '194.88.219.78', '194.88.219.70', '194.88.219.71',
        '194.88.219.72', '194.88.219.79', '194.88.219.80', '194.88.219.81',
        '194.88.219.82', '194.88.219.83', '194.88.219.84', '194.88.219.85',
        '194.88.219.86', '194.88.219.87', '194.88.219.88', '194.88.219.89',
        '194.88.219.92', '194.88.218.119', '194.88.218.120', '185.100.66.145',
        '185.100.66.146', '185.100.66.147'
    ];

    public function isFromBinotel(?string $ip = null): bool
    {
        $ip ??= $_SERVER['REMOTE_ADDR'] ?? '';
        return in_array($ip, self::BINOTEL_IPS, true);
    }

    public function getRequestData(): array
    {
        return $_POST;
    }

    /**
     * Helper to respond to API-CALL-SETTINGS requests.
     */
    public function respondWithCustomerData(array $customerData): void
    {
        $this->jsonResponse(['customerData' => $customerData]);
    }

    public function respondWithRouteData(string $type, string $id): void
    {
        $this->jsonResponse(['routeData' => ['type' => $type, 'id' => $id]]);
    }

    public function respondWithVariables(array $variables): void
    {
        $this->jsonResponse(['variables' => $variables]);
    }

    private function jsonResponse(array $data): void
    {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}

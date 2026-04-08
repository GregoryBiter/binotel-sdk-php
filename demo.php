<?php

require_once __DIR__ . '/vendor/autoload.php';

use Binotel\Sdk\Client;
use Binotel\Sdk\Http\HttpClientInterface;

/**
 * A simple mock HTTP client for demonstration purposes.
 */
class MockHttpClient implements HttpClientInterface
{
    public function post(string $url, array $params): array
    {
        echo "Sending request to: $url\n";
        echo "Params: " . json_encode($params, JSON_PRETTY_PRINT) . "\n\n";

        // Mocking a successful response for calls/internal-number-to-external-number
        if (str_contains($url, 'calls/internal-number-to-external-number')) {
            return [
                'status' => 'success',
                'generalCallID' => '12345678'
            ];
        }

        // Mocking a response for stats/call-details
        if (str_contains($url, 'stats/call-details')) {
            return [
                'status' => 'success',
                'callDetails' => [
                    '12345678' => [
                        'disposition' => 'ANSWERED',
                        'duration' => 45,
                        'billsec' => 30
                    ]
                ]
            ];
        }

        return ['status' => 'success'];
    }
}

// 1. Initialize the SDK
$key = 'your-api-key';
$secret = 'your-api-secret';

// In real use: $binotel = new Client($key, $secret);
// For demo, we use the mock client:
$mockClient = new MockHttpClient();
$binotel = new Client($key, $secret, $mockClient);

try {
    echo "--- Initiating a call ---\n";
    $callResponse = $binotel->calls->internalToExternal('910', '0443334023');
    echo "Call ID: " . $callResponse['generalCallID'] . "\n\n";

    echo "--- Getting call details ---\n";
    $details = $binotel->stats->callDetails($callResponse['generalCallID']);
    print_r($details['callDetails']);

    echo "\n--- Listing employees ---\n";
    $employees = $binotel->settings->listOfEmployees();
    echo "Status: " . $employees['status'] . "\n";

} catch (\Binotel\Sdk\Exceptions\BinotelException $e) {
    echo "Error: " . $e->getMessage() . "\n";
    if ($e instanceof \Binotel\Sdk\Exceptions\ApiResponseException) {
        print_r($e->getResponse());
    }
}

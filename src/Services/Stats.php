<?php

namespace Binotel\Sdk\Services;

class Stats extends AbstractService
{
    public function outgoingCallsForPeriod(int $startTime, int $stopTime): array
    {
        return $this->request('stats/outgoing-calls-for-period', [
            'startTime' => $startTime,
            'stopTime' => $stopTime,
        ]);
    }

    public function incomingCallsForPeriod(int $startTime, int $stopTime): array
    {
        return $this->request('stats/incoming-calls-for-period', [
            'startTime' => $startTime,
            'stopTime' => $stopTime,
        ]);
    }

    public function allIncomingCallsSince(int $timestamp): array
    {
        return $this->request('stats/all-incoming-calls-since', [
            'timestamp' => $timestamp,
        ]);
    }

    public function allOutgoingCallsSince(int $timestamp): array
    {
        return $this->request('stats/all-outgoing-calls-since', [
            'timestamp' => $timestamp,
        ]);
    }

    public function onlineCalls(): array
    {
        return $this->request('stats/online-calls');
    }

    public function listOfCallsPerDay(int $dayTimestamp): array
    {
        return $this->request('stats/list-of-calls-per-day', [
            'dayInTimestamp' => $dayTimestamp,
        ]);
    }

    public function listOfCallsForPeriod(int $startTime, int $stopTime): array
    {
        return $this->request('stats/list-of-calls-for-period', [
            'startTime' => $startTime,
            'stopTime' => $stopTime,
        ]);
    }

    public function calltrackingCallsForPeriod(int $startTime, int $stopTime): array
    {
        return $this->request('stats/calltracking-calls-for-period', [
            'startTime' => $startTime,
            'stopTime' => $stopTime,
        ]);
    }

    public function listOfCallsByInternalNumberForPeriod(string $internalNumber, int $startTime, int $stopTime): array
    {
        return $this->request('stats/list-of-calls-by-internal-number-for-period', [
            'internalNumber' => $internalNumber,
            'startTime' => $startTime,
            'stopTime' => $stopTime,
        ]);
    }

    public function listOfLostCallsToday(): array
    {
        return $this->request('stats/list-of-lost-calls-today');
    }

    public function historyByExternalNumbers(array $externalNumbers): array
    {
        return $this->request('stats/history-by-external-number', [
            'externalNumbers' => $externalNumbers,
        ]);
    }

    public function historyByCustomerId(string $customerID): array
    {
        return $this->request('stats/history-by-customer-id', [
            'customerID' => $customerID,
        ]);
    }

    public function recentCallsByInternalNumber(string $internalNumber): array
    {
        return $this->request('stats/recent-calls-by-internal-number', [
            'internalNumber' => $internalNumber,
        ]);
    }

    public function callDetails(array|string $generalCallID): array
    {
        return $this->request('stats/call-details', [
            'generalCallID' => (array)$generalCallID,
        ]);
    }

    public function callRecord(string $generalCallID): array
    {
        return $this->request('stats/call-record', [
            'generalCallID' => $generalCallID,
        ]);
    }
}

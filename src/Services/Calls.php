<?php

namespace Binotel\Sdk\Services;

class Calls extends AbstractService
{
    public function internalToExternal(string $internalNumber, string $externalNumber, ?int $callerIdForEmployee = null, array $extraParams = []): array
    {
        $params = array_merge([
            'internalNumber' => $internalNumber,
            'externalNumber' => $externalNumber,
        ], $extraParams);

        if ($callerIdForEmployee !== null) {
            $params['callerIdForEmployee'] = $callerIdForEmployee;
        }

        return $this->request('calls/internal-number-to-external-number', $params);
    }

    public function externalToExternal(string $externalNumber1, string $externalNumber2, string $phoneNumber, int $limitCallTime = 0): array
    {
        $params = [
            'externalNumber1' => $externalNumber1,
            'externalNumber2' => $externalNumber2,
            'phoneNumber' => $phoneNumber,
        ];

        if ($limitCallTime > 0) {
            $params['limitCallTime'] = $limitCallTime;
        }

        return $this->request('calls/external-number-to-external-number', $params);
    }

    public function attendedTransfer(string $generalCallID, string $externalNumber): array
    {
        return $this->request('calls/attended-call-transfer', [
            'generalCallID' => $generalCallID,
            'externalNumber' => $externalNumber,
        ]);
    }

    public function hangup(string $generalCallID): array
    {
        return $this->request('calls/hangup-call', [
            'generalCallID' => $generalCallID,
        ]);
    }

    public function callWithAnnouncement(string $externalNumber, string $voiceFileID): array
    {
        return $this->request('calls/call-with-announcement', [
            'externalNumber' => $externalNumber,
            'voiceFileID' => $voiceFileID,
        ]);
    }

    public function callWithIvr(string $externalNumber, string $ivrName): array
    {
        return $this->request('calls/call-with-interactive-voice-response', [
            'externalNumber' => $externalNumber,
            'ivrName' => $ivrName,
        ]);
    }
}

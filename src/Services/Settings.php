<?php

namespace Binotel\Sdk\Services;

class Settings extends AbstractService
{
    public function listOfEmployees(): array
    {
        return $this->request('settings/list-of-employees');
    }

    public function listOfRoutes(): array
    {
        return $this->request('settings/list-of-routes');
    }

    public function listOfVoiceFiles(): array
    {
        return $this->request('settings/list-of-voice-files');
    }

    public function changeEmployeePresenceState(string $employeeID, string $presenceState): array
    {
        return $this->request('settings/change-employee-presence-state', [
            'employeeID' => $employeeID,
            'presenceState' => $presenceState,
        ]);
    }
}

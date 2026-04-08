<?php

namespace Binotel\Sdk\Services;

class Customers extends AbstractService
{
    public function list(): array
    {
        return $this->request('customers/list');
    }

    public function takeById(array|string $customerID): array
    {
        return $this->request('customers/take-by-id', [
            'customerID' => (array)$customerID,
        ]);
    }

    public function takeByLabel(string $labelID): array
    {
        return $this->request('customers/take-by-label', [
            'labelID' => $labelID,
        ]);
    }

    public function search(string $subject): array
    {
        return $this->request('customers/search', [
            'subject' => $subject,
        ]);
    }

    public function create(array $data): array
    {
        return $this->request('customers/create', $data);
    }

    public function update(string $id, array $data): array
    {
        $data['id'] = $id;
        return $this->request('customers/update', $data);
    }

    public function delete(array|string $customerID): array
    {
        return $this->request('customers/delete', [
            'customerID' => (array)$customerID,
        ]);
    }

    public function listOfLabels(): array
    {
        return $this->request('customers/listOfLabels');
    }
}

<?php

namespace Binotel\Sdk\Exceptions;

class ApiResponseException extends BinotelException
{
    public function __construct(
        string $message,
        int $code = 0,
        private readonly ?array $response = null
    ) {
        parent::__construct($message, $code);
    }

    public function getResponse(): ?array
    {
        return $this->response;
    }
}

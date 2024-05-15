<?php

namespace Floodx92\KhGateway\Exception;

class HttpException extends \Exception
{
    public int $resultCode = 999;
    public string $resultMessage = '';

    public function __construct(
        string $message,
        int $code,
        ?\Throwable $previous = null,
        string $resultMessage = '',
        int $resultCode = 999
    ) {
        parent::__construct($message, $code, $previous);
        $this->resultMessage = $resultMessage;
        $this->resultCode = $resultCode;
    }

    public function getResultCode(): int
    {
        return $this->resultCode;
    }

    public function getResultMessage(): string
    {
        return $this->resultMessage;
    }
}

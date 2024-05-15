<?php

namespace Floodx92\KhGateway\Model\Response;

use Floodx92\KhGateway\Model\Base;

class EchoResponse extends Base
{
    public ?int $resultCode = null;
    public ?string $resultMessage = null;

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->dttm,
            $this->resultCode,
            $this->resultMessage,
        ], fn ($value) => null !== $value)));
    }
}

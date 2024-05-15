<?php

namespace Floodx92\KhGateway\Model\Response;

use Floodx92\KhGateway\Model\Base;
use Floodx92\KhGateway\Model\GooglePayInitParams;

class GooglePayEchoResponse extends Base
{
    public ?int $resultCode = null;
    public ?string $resultMessage = null;
    public ?GooglePayInitParams $initParams = null;

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->dttm,
            $this->resultCode,
            $this->resultMessage,
            $this->initParams?->toSignable(),
        ], fn ($value) => null !== $value)));
    }
}

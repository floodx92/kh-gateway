<?php

namespace Floodx92\KhGateway\Model\Response;

use Floodx92\KhGateway\Model\ApplePayInitParams;
use Floodx92\KhGateway\Model\Base;

class ApplePayEchoResponse extends Base
{
    public ?int $resultCode = null;
    public ?string $resultMessage = null;
    public ?ApplePayInitParams $initParams = null;

    public static function make(
    ): self {
        return new self();
    }

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->dttm,
            $this->resultCode,
            $this->resultMessage,
            $this->initParams?->toSignable(),
        ])));
    }
}

<?php

namespace Floodx92\KhGateway\Model;

class AuthInit extends Base
{
    public ?Endpoint $browserInit = null;
    public ?SdkInit $sdkInit = null;

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->browserInit?->toSignable(),
            $this->sdkInit?->toSignable(),
        ], fn ($value) => null !== $value)));
    }
}

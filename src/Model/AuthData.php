<?php

namespace Floodx92\KhGateway\Model;

class AuthData extends Base
{
    public ?Auth3dsBrowser $browser = null;
    public ?Auth3dsSdk $sdk = null;

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->browser?->toSignable(),
            $this->sdk?->toSignable(),
        ], fn ($value) => null !== $value)));
    }
}

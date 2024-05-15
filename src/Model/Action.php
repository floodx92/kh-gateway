<?php

namespace Floodx92\KhGateway\Model;

class Action extends Base
{
    public AuthInit $fingerprint;
    public Authenticate $authenticate;

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->fingerprint->toSignable(),
            $this->authenticate->toSignable(),
        ], fn ($value) => null !== $value)));
    }
}

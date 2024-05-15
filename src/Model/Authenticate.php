<?php

namespace Floodx92\KhGateway\Model;

class Authenticate extends Base
{
    public ?Endpoint $browserChallenge = null;

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->browserChallenge?->toSignable(),
            $this->browserChallenge?->toSignable(),
        ], fn ($value) => null !== $value)));
    }
}

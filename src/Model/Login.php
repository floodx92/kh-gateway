<?php

namespace Floodx92\KhGateway\Model;

class Login extends Base
{
    public ?string $auth = null;
    public ?string $authAt = null;
    public ?string $authData = null;

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->auth,
            $this->authAt,
            $this->authData,
        ], fn ($value) => null !== $value)));
    }
}

<?php

namespace Floodx92\KhGateway\Model;

class Extension extends Base
{
    public ?string $extension = null;

    public function toSignable(): string
    {
        return '';
    }
}

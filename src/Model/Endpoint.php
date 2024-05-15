<?php

namespace Floodx92\KhGateway\Model;

class Endpoint extends Base
{
    public ?string $url = null;
    public ?string $method = 'GET';
    /** @var string[] */
    public ?array $params = null;

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->url,
            $this->method,
        ], fn ($value) => null !== $value)));
    }
}

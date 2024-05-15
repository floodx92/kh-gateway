<?php

namespace Floodx92\KhGateway\Model\Request;

use Floodx92\KhGateway\Model\Base;

class EchoRequest extends Base
{
    public function __construct(
        public string $merchantId,
    ) {
    }

    public static function make(string $merchantId): self
    {
        return new self($merchantId);
    }

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', [
            $this->merchantId,
            $this->dttm,
        ]));
    }
}

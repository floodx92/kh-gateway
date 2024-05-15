<?php

namespace Floodx92\KhGateway\Model\Request;

use Floodx92\KhGateway\Model\Base;

class OneClickEchoRequest extends Base
{
    public function __construct(
        public ?string $merchantId = null,
        public ?string $origPayId = null,
    ) {
    }

    public static function make(
        ?string $merchantId = null,
        ?string $origPayId = null,
    ): self {
        return new self($merchantId, $origPayId);
    }

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->merchantId,
            $this->origPayId,
            $this->dttm,
        ], fn ($value) => null !== $value)));
    }
}

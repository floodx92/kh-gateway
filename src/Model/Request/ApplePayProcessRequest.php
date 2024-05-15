<?php

namespace Floodx92\KhGateway\Model\Request;

use Floodx92\KhGateway\Model\AuthData;
use Floodx92\KhGateway\Model\Base;

class ApplePayProcessRequest extends Base
{
    public function __construct(
        public ?string $merchantId = null,
        public ?string $payId = null,
        public ?AuthData $fingerprint = null,
    ) {
    }

    public static function make(
        ?string $merchantId = null,
        ?string $payId = null,
        ?AuthData $fingerprint = null,
    ): self {
        return new self($merchantId, $payId, $fingerprint);
    }

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->merchantId,
            $this->payId,
            $this->dttm,
            $this->fingerprint?->toSignable(),
        ], fn ($value) => null !== $value)));
    }
}

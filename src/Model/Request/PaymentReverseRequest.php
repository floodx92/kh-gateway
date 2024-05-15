<?php

namespace Floodx92\KhGateway\Model\Request;

use Floodx92\KhGateway\Model\Base;

class PaymentReverseRequest extends Base
{
    public ?string $merchantId = null;
    public ?string $payId = null;

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->merchantId,
            $this->payId,
            $this->dttm,
        ], fn ($value) => null !== $value)));
    }
}

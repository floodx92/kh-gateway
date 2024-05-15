<?php

namespace Floodx92\KhGateway\Model\Request;

use Floodx92\KhGateway\Model\Base;

class PaymentStatusRequest extends Base
{
    public string $payId;
    public string $merchantId;

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->merchantId,
            $this->payId,
            $this->dttm,
        ], fn ($value) => null !== $value)));
    }
}

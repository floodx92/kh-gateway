<?php

namespace Floodx92\KhGateway\Model\Request;

use Floodx92\KhGateway\Model\Base;

class PaymentRefundRequest extends Base
{
    public ?string $merchantId = null;
    public ?string $payId = null;
    public ?float $amount = null;

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->merchantId,
            $this->payId,
            $this->dttm,
            $this->amount,
        ], fn ($value) => null !== $value)));
    }
}

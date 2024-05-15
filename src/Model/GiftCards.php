<?php

namespace Floodx92\KhGateway\Model;

class GiftCards extends Base
{
    public ?float $totalAmount = null;
    public ?string $currency = null;
    public ?int $quantity = null;

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->totalAmount,
            $this->currency,
            $this->quantity,
        ], fn ($value) => null !== $value)));
    }
}

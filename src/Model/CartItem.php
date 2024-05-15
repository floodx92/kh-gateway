<?php

namespace Floodx92\KhGateway\Model;

class CartItem extends Base
{
    public ?string $name = null;
    public ?int $quantity = 1;
    public ?float $amount = null;
    public ?string $description = null;

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->name,
            $this->quantity,
            $this->amount,
            $this->description,
        ], fn ($value) => null !== $value)));
    }
}

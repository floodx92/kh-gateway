<?php

namespace Floodx92\KhGateway\Model;

class Address extends Base
{
    public ?string $address1 = null;
    public ?string $address2 = null;
    public ?string $address3 = null;
    public ?string $city = null;
    public ?string $zip = null;
    public ?string $state = null;
    public ?string $country = null;

    public static function make(): self
    {
        return new self();
    }

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->address1,
            $this->address2,
            $this->address3,
            $this->city,
            $this->zip,
            $this->state,
            $this->country,
        ], fn ($value) => null !== $value)));
    }
}

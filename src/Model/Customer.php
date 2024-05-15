<?php

namespace Floodx92\KhGateway\Model;

class Customer extends Base
{
    public ?string $merchantId = null;
    public ?string $name = null;
    public ?string $email = null;
    public ?string $homePhone = null;
    public ?string $workPhone = null;
    public ?string $mobilePhone = null;
    public ?Account $account = null;
    public ?Login $login = null;

    public static function make(): self
    {
        return new self();
    }

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->name,
            $this->email,
            $this->homePhone,
            $this->workPhone,
            $this->mobilePhone,
            $this->account?->toSignable(),
            $this->login?->toSignable(),
        ], fn ($value) => null !== $value)));
    }
}

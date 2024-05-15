<?php

namespace Floodx92\KhGateway\Model;

class Account extends Base
{
    public ?string $createdAt = null;
    public ?string $changedAt = null;
    public ?string $changedPwdAt = null;
    public ?int $orderHistory = null;
    public ?int $paymentsDay = null;
    public ?int $paymentsYear = null;
    public ?int $oneclickAdds = null;
    public ?bool $suspicious = null;

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->createdAt,
            $this->changedAt,
            $this->changedPwdAt,
            $this->orderHistory,
            $this->paymentsDay,
            $this->paymentsYear,
            $this->oneclickAdds,
            $this->safeBool($this->suspicious),
        ], fn ($value) => null !== $value)));
    }
}

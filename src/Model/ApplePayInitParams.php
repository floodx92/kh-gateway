<?php

namespace Floodx92\KhGateway\Model;

class ApplePayInitParams extends Base
{
    public ?string $countryCode = null;
    /** @var string[]|null */
    public ?array $supportedNetworks = null;
    /** @var string[]|null */
    public ?array $merchantCapabilities = null;

    public static function make(): self
    {
        return new self();
    }

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->countryCode,
            implode('|', $this->supportedNetworks ?? []),
            implode('|', $this->merchantCapabilities ?? []),
        ], fn ($value) => null !== $value)));
    }
}

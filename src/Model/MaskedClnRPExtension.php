<?php

namespace Floodx92\KhGateway\Model;

class MaskedClnRPExtension extends Extension
{
    public ?string $extension = 'maskClnRP';
    public ?string $maskedCln = null;
    public ?string $longMaskedCln = null;
    public ?string $expiration = null;

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->extension,
            $this->dttm,
            $this->maskedCln,
            $this->expiration,
            $this->longMaskedCln,
        ], fn ($value) => null !== $value)));
    }
}

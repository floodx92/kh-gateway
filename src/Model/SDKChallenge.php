<?php

namespace Floodx92\KhGateway\Model;

class SDKChallenge extends Base
{
    public ?string $threeDSServerTransID = null;
    public ?string $acsReferenceNumber = null;
    public ?string $acsTransID = null;
    public ?string $acsSignedContent = null;

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->threeDSServerTransID,
            $this->acsReferenceNumber,
            $this->acsTransID,
            $this->acsSignedContent,
        ], fn ($value) => null !== $value)));
    }
}

<?php

namespace Floodx92\KhGateway\Model;

class Auth3dsSdk extends Base
{
    public ?string $appID = null;
    public ?string $encData = null;
    public ?string $ephemPubKey = null;
    public ?int $maxTimeout = null;
    public ?string $referenceNumber = null;
    public ?string $transID = null;

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->appID,
            $this->encData,
            $this->ephemPubKey,
            $this->maxTimeout,
            $this->referenceNumber,
            $this->transID,
        ], fn ($value) => null !== $value)));
    }
}

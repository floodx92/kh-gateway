<?php

namespace Floodx92\KhGateway\Model;

class SdkInit extends Base
{
    public ?string $directoryServerID = null;
    public ?string $schemeId = null;
    public ?string $messageVersion = null;

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->directoryServerID,
            $this->schemeId,
            $this->messageVersion,
        ], fn ($value) => null !== $value)));
    }
}

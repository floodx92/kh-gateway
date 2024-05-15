<?php

namespace Floodx92\KhGateway\Model\Response;

use Floodx92\KhGateway\Model\Base;
use Floodx92\KhGateway\Model\Extension;

class OneClickEchoResponse extends Base
{
    public ?string $origPayId = null;
    public ?int $resultCode = null;
    public ?string $resultMessage = null;
    /** @var Extension[] */
    public ?array $extensions = null;

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->origPayId,
            $this->dttm,
            $this->resultCode,
            $this->resultMessage,
        ], fn ($value) => null !== $value)));
    }
}

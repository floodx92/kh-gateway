<?php

namespace Floodx92\KhGateway\Model\Response;

use Floodx92\KhGateway\Model\Action;
use Floodx92\KhGateway\Model\Base;
use Floodx92\KhGateway\Model\Extension;

class PaymentStatusResponse extends Base
{
    public ?string $payId = null;
    public ?int $resultCode = null;
    public ?string $resultMessage = null;
    public ?int $paymentStatus = null;
    public ?string $authCode = null;
    public ?string $statusDetail = null;
    public ?Action $actions = null;
    /** @var Extension[] */
    public ?array $extensions = null;

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->payId,
            $this->dttm,
            $this->resultCode,
            $this->resultMessage,
            $this->paymentStatus,
            $this->authCode,
            $this->statusDetail,
            $this->actions?->toSignable(),
        ], fn ($value) => null !== $value)));
    }
}

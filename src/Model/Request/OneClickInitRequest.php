<?php

namespace Floodx92\KhGateway\Model\Request;

use Floodx92\KhGateway\Model\Base;
use Floodx92\KhGateway\Model\Customer;
use Floodx92\KhGateway\Model\Extension;
use Floodx92\KhGateway\Model\Order;

class OneClickInitRequest extends Base
{
    public ?string $merchantId = null;
    public ?float $totalAmount = null;
    public ?string $currency = null;
    public ?string $origPayId = null;
    public ?string $orderNo = null;
    public ?string $payMethod = null;
    public ?string $clientIp = null;
    public ?bool $closePayment = null;
    public ?string $returnUrl = null;
    public ?string $returnMethod = null;
    public ?Customer $customer = null;
    public ?Order $order = null;
    public ?bool $clientInitiated = null;
    public ?bool $sdkUsed = null;
    public ?string $merchantData = null;
    /** @var Extension[] */
    public ?array $extensions = null;
    public ?int $ttlSec = null;

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->merchantId,
            $this->origPayId,
            $this->orderNo,
            $this->dttm,
            $this->clientIp,
            $this->totalAmount,
            $this->currency,
            $this->closePayment,
            $this->returnUrl,
            $this->returnMethod,
            $this->customer?->toSignable(),
            $this->order?->toSignable(),
            $this->safeBool($this->clientInitiated),
            $this->safeBool($this->sdkUsed),
            $this->merchantData,
            $this->ttlSec,
        ], fn ($value) => null !== $value)));
    }
}

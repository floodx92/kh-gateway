<?php

namespace Floodx92\KhGateway\Model\Response;

use Floodx92\KhGateway\Enum\ReturnMethod;
use Floodx92\KhGateway\Model\Base;
use Floodx92\KhGateway\Model\Customer;
use Floodx92\KhGateway\Model\Extension;
use Floodx92\KhGateway\Model\Order;

class GooglePayInitRequest extends Base
{
    public ?string $merchantId = null;
    public ?float $totalAmount = null;
    public ?string $currency = null;
    public ?string $orderNo = null;
    public ?string $payMethod = null;
    public ?string $clientIp = null;
    public ?bool $closePayment = null;
    public ?string $payload = null;
    public ?string $returnUrl = null;
    public ?ReturnMethod $returnMethod = null;
    public ?Customer $customer = null;
    public ?Order $order = null;
    public ?bool $sdkUsed = null;
    public ?string $merchantData = null;
    public ?int $ttlSec = null;
    /** @var Extension[] */
    public ?array $extensions = null;

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->merchantId,
            $this->orderNo,
            $this->dttm,
            $this->clientIp,
            $this->totalAmount,
            $this->currency,
            $this->safeBool($this->closePayment),
            $this->merchantData,
            $this->payload,
            $this->returnUrl,
            $this->returnMethod?->value,
            $this->customer?->toSignable(),
            $this->order?->toSignable(),
            $this->ttlSec,
        ], fn ($value) => null !== $value)));
    }
}

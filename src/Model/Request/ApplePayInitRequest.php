<?php

namespace Floodx92\KhGateway\Model\Request;

use Floodx92\KhGateway\Enum\PaymentMethod;
use Floodx92\KhGateway\Enum\ReturnMethod;
use Floodx92\KhGateway\Model\Base;
use Floodx92\KhGateway\Model\Customer;
use Floodx92\KhGateway\Model\Extension;
use Floodx92\KhGateway\Model\Order;

class ApplePayInitRequest extends Base
{
    public ?string $merchantId;
    public ?string $currency;
    public ?float $totalAmount;
    public ?string $orderNo;
    public ?PaymentMethod $payMethod;
    public ?string $clientIp;
    public ?bool $closePayment;
    public ?string $payload;
    public ?string $returnUrl;
    public ?ReturnMethod $returnMethod;
    public ?Customer $customer;
    public ?Order $order;
    public ?bool $sdkUsed;
    public ?string $merchantData;
    public ?int $ttlSec;
    /** @var Extension[] */
    public ?array $extensions;

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
            $this->payload,
            $this->returnUrl,
            $this->returnMethod?->value,
            $this->customer?->toSignable(),
            $this->order?->toSignable(),
            $this->safeBool($this->sdkUsed),
            $this->merchantData,
            $this->ttlSec,
        ], fn ($value) => null !== $value)));
    }
}

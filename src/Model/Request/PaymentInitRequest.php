<?php

namespace Floodx92\KhGateway\Model\Request;

use Floodx92\KhGateway\Enum\PaymentMethod;
use Floodx92\KhGateway\Enum\PayOperation;
use Floodx92\KhGateway\Enum\ReturnMethod;
use Floodx92\KhGateway\Model\Base;
use Floodx92\KhGateway\Model\CartItem;
use Floodx92\KhGateway\Model\Customer;
use Floodx92\KhGateway\Model\Order;

class PaymentInitRequest extends Base
{
    public ?string $merchantId = null;
    public ?float $totalAmount = null;
    public ?string $currency = null;
    public ?string $orderNo = null;
    public ?PayOperation $payOperation = null;
    public ?PaymentMethod $payMethod = null;
    public ?bool $closePayment = null;
    /** @var CartItem[] */
    public ?array $cart = null;
    public ?string $returnUrl = null;
    public ?ReturnMethod $returnMethod = null;
    public ?Customer $customer = null;
    public ?Order $order = null;
    public ?string $merchantData = null;
    public ?string $language = null;
    public ?int $ttlSec = null;

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->merchantId,
            $this->orderNo,
            $this->dttm,
            $this->payOperation?->value,
            $this->payMethod?->value,
            $this->totalAmount,
            $this->currency,
            $this->safeBool($this->closePayment),
            $this->returnUrl,
            $this->returnMethod?->value,
            !empty($this->cart) ? implode('|', array_map(fn ($item) => $item->toSignable(), $this->cart)) : null,
            $this->customer?->toSignable(),
            $this->order?->toSignable(),
            $this->merchantData,
            $this->language,
            $this->ttlSec,
        ], fn ($value) => null !== $value)));
    }
}

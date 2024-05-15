<?php

namespace Floodx92\KhGateway\Model;

use Floodx92\KhGateway\Enum\DeliveryMode;
use Floodx92\KhGateway\Enum\DeliveryType;
use Floodx92\KhGateway\Enum\OrderType;

class Order extends Base
{
    public ?OrderType $type = null;
    /**
     * Can be 'now', 'later', or it is possible to fill in the expected
     * date of availability of pre-ordered goods in ISO8061 format,
     * eg "YYYY-MM-DD".
     */
    public ?string $availability = null;
    public ?DeliveryType $delivery = null;
    public ?DeliveryMode $deliveryMode = null;
    public ?string $deliveryEmail = null;
    public ?bool $nameMatch = null;
    public ?bool $addressMatch = null;
    public ?Address $billing = null;
    public ?Address $shipping = null;
    /**
     * Date of adding the shipping address. ISO8061 format is accepted.
     */
    public ?string $shippingAddedAt = null;
    public ?bool $reorder = null;
    public ?GiftCards $giftcards = null;

    public function toSignable(): string
    {
        return $this->removeLast(implode('|', array_filter([
            $this->type,
            $this->availability,
            $this->delivery?->value,
            $this->deliveryMode?->value,
            $this->deliveryEmail,
            $this->safeBool($this->nameMatch),
            $this->safeBool($this->addressMatch),
            $this->billing->toSignable(),
            $this->shipping->toSignable(),
            $this->shippingAddedAt,
            $this->reorder,
            $this->giftcards->toSignable(),
        ], fn ($value) => null !== $value)));
    }
}

<?php

namespace Floodx92\KhGateway\Enum;

enum DeliveryType: string
{
    case SHIPPING = 'shipping';
    case SHIPPING_VERIFIED = 'shipping_verified';
    case INSTORE = 'instore';
    case DIGITAL = 'digital';
    case TICKET = 'ticket';
    case ORDER = 'order';
}

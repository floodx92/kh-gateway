<?php

namespace Floodx92\KhGateway\Enum;

enum DeliveryMode: string
{
    case ELECTRONIC = '0';
    case SAME_DAY = '1';
    case NEXT_DAY = '2';
    case TWO_DAYS_LATER = '3';
}

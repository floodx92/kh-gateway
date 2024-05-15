<?php

namespace Floodx92\KhGateway\Enum;

enum PayOperation: string
{
    case PAYMENT = 'payment';
    case ONECLICK_PAYMENT = 'oneclickPayment';
}

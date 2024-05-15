<?php

namespace Floodx92\KhGateway\Enum;

enum OrderType: string
{
    case PURCHASE = 'purchase';
    case BALANCE = 'balance';
    case PREPAID = 'prepaid';
    case CASH = 'cash';
    case CHECK = 'check';
}

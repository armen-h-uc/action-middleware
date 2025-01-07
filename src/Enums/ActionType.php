<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\Enums;

use Uc\ActionMiddleware\Traits\EnumToArray;

enum ActionType: string
{
    use EnumToArray;

    case CREATE_CUSTOMER = 'create_customer';
}

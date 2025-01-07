<?php

declare(strict_types=1);

namespace Uc\ActionMiddleware\Enums;

use Uc\ActionMiddleware\Traits\EnumToArray;

enum ExcludedKey: string
{
    use EnumToArray;

    case PASSWORD = 'password';
    case PASSWORD_CONFIRMATION = 'password_confirmation';
    case TOKEN = 'token';

    /**
     * @return array
     */
    public static function getExcludedKeys(): array
    {
        return [
            self::PASSWORD->value,
            self::PASSWORD_CONFIRMATION->value,
            self::TOKEN->value,
        ];
    }
}

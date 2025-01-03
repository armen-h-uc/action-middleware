<?php

declare(strict_types=1);

namespace ActionMiddleware\Traits;

use function strtoupper;

trait EnumToArray
{
    /**
     * @return array<string>
     */
    public static function names(): array
    {
        return array_column(self::cases(), 'name');
    }

    /**
     * @return array<int|string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * @return array<string>
     */
    public static function getNamesPerValues(): array
    {
        return array_combine(self::values(), self::names());
    }

    /**
     * @return array<int|string>
     */
    public static function getValuesPerNames(): array
    {
        return array_combine(self::names(), self::values());
    }

    /**
     * @param string $name
     *
     * @return int|string|null
     */
    public static function getValueByName(string $name): int|string|null
    {
        foreach (self::cases() as $enum) {
            if ($enum->name === $name) {
                return $enum->value;
            }
        }

        return null;
    }

    /**
     * @param mixed $value
     *
     * @return int|string|null
     */
    public static function getNameByValue(mixed $value): int|string|null
    {
        foreach (self::cases() as $enum) {
            if ($enum->value === $value) {
                return $enum->name;
            }
        }

        return null;
    }

    /**
     * @param string $name
     *
     * @return static|null
     */
    public static function getByName(string $name): static|null
    {
        foreach (self::cases() as $enum) {
            if (strtoupper($enum->name) === strtoupper($name)) {
                return $enum;
            }
        }

        return null;
    }

    /**
     * @return string
     */
    public static function commaSeparatedValues(): string
    {
        return implode(',', self::values());
    }
}

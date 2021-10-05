<?php

namespace App\Shared\Domain\ValueObject;

use InvalidArgumentException;

abstract class EnumValueObject
{
    protected static array $indexes = [];

    protected static array $values = [];

    public function __construct(protected string|int|float $value)
    {
        $this->cacheEnumValues();
        $this->assertValueIsValid();
    }

    protected function values(): array
    {
        return property_exists(static::class, 'values') ? static::$values : [];
    }

    protected function cacheValue(string|int|float $value): void
    {
        if (array_key_exists($value, static::$indexes))
            return;

        static::$indexes[$value] = true;
    }

    protected function cacheEnumValues(): void
    {
        collect($this->values())->each(fn ($value) => $this->cacheValue($value));
    }

    public static function fromValue(string|int|float $value)
    {
        return new static($value);
    }


    public function value(): string|int|float
    {
        return $this->value;
    }

    protected function assertValueIsValid()
    {
        if (array_key_exists($this->value, static::$indexes))
            return;

        throw new InvalidArgumentException(
            static::class . " only supports the values " . implode(", ", $this->values()) . ". Got {$this->value}"
        );
    }
}

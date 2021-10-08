<?php

namespace App\Shared\Domain\ValueObject;

use DateTimeInterface;

abstract class DateValueObject
{
    const DATE_FORMAT = "Y-m-d";

    protected string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public static function fromValue(string $value)
    {
        return new static($value);
    }

    public static function fromDate(DateTimeInterface $value)
    {
        return new static($value->format(static::DATE_FORMAT));
    }

    public function value(): string
    {
        return $this->value;
    }
}

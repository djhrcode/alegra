<?php

namespace App\Shared\Domain\ValueObject;

abstract class FloatValueObject
{
    protected float $value;

    public function __construct(float $value)
    {
        $this->value = $value;
    }

    public static function fromValue(float $value)
    {
        return new static($value);
    }

    public function value(): float
    {
        return $this->value;
    }
}

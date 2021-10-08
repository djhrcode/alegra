<?php

namespace App\Invoice\Domain\ValueObjects;

use App\Shared\Domain\ValueObject\EnumValueObject;

final class InvoiceStatus extends EnumValueObject
{
    const OPEN = 'open';
    const DRAFT = 'draft';

    protected static array $values = [InvoiceStatus::OPEN, InvoiceStatus::DRAFT];
}

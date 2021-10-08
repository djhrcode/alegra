<?php

namespace App\Invoice\Domain;

use App\Invoice\Domain\ValueObjects\InvoiceItemDescription;
use App\Invoice\Domain\ValueObjects\InvoiceItemId;
use App\Invoice\Domain\ValueObjects\InvoiceItemPrice;
use App\Invoice\Domain\ValueObjects\InvoiceItemQuantity;

final class InvoiceItem
{
    public function __construct(
        private InvoiceItemId $id,
        private InvoiceItemPrice $price,
        private ?InvoiceItemDescription $description = null,
        private ?InvoiceItemQuantity $quantity = null
    ) {
        $this->description = $description ?? InvoiceItemDescription::fromValue("");
        $this->quantity = $quantity ?? InvoiceItemQuantity::fromValue(1);
    }

    public static function fromPrimitives(
        int $id,
        float $price,
        string $description = "",
        int $quantity = 1
    ): static {
        return new static(
            InvoiceItemId::fromValue($id),
            InvoiceItemPrice::fromValue($price),
            InvoiceItemDescription::fromValue($description),
            InvoiceItemQuantity::fromValue($quantity),
        );
    }

    public function id(): InvoiceItemId
    {
        return $this->id;
    }

    public function description(): InvoiceItemDescription
    {
        return $this->description;
    }

    public function price(): InvoiceItemPrice
    {
        return $this->price;
    }

    public function quantity(): InvoiceItemQuantity
    {
        return $this->quantity;
    }
}

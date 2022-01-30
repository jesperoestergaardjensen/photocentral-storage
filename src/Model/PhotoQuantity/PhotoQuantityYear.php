<?php

namespace PhotoCentralStorage\Model\PhotoQuantity;

use JsonSerializable;

class PhotoQuantityYear implements JsonSerializable
{
    private string $year_label;
    private int $year_value;
    private int $quantity;

    public function __construct(string $year_label, int $year_value, int $quantity)
    {
        $this->year_label = $year_label;
        $this->year_value = $year_value;
        $this->quantity = $quantity;
    }

    public function getYearLabel(): string
    {
        return $this->year_label;
    }

    public function getYearValue(): int
    {
        return $this->year_value;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function toArray(): array
    {
        return [
            'year_label' => $this->year_label,
            'year_value' => $this->year_value,
            'quantity'  => $this->quantity
        ];
    }

    public static function fromArray($array): self
    {
        return new self($array['year_label'], $array['year_value'], $array['quantity']);
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}

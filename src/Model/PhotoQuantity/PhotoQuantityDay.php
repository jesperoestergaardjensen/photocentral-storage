<?php

namespace PhotoCentralStorage\Model\PhotoQuantity;

use JsonSerializable;

class PhotoQuantityDay implements JsonSerializable
{
    private string $day_label;
    private int $day_value;
    private int $quantity;

    public function __construct(string $day_label, int $day_value, int $quantity)
    {
        $this->day_label = $day_label;
        $this->day_value = $day_value;
        $this->quantity = $quantity;
    }

    public function getDayLabel(): string
    {
        return $this->day_label;
    }

    public function getDayValue(): int
    {
        return $this->day_value;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function toArray(): array
    {
        return [
            'day_label' => $this->day_label,
            'day_value' => $this->day_value,
            'quantity'  => $this->quantity
        ];
    }

    public static function fromArray($array): self
    {
        return new self($array['day_label'], $array['day_value'], $array['quantity']);
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }
}


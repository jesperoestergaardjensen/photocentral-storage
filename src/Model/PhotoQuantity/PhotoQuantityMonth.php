<?php

namespace PhotoCentralStorage\Model\PhotoQuantity;

use JsonSerializable;

class PhotoQuantityMonth implements JsonSerializable
{
    private string $month_label;
    private int $month_value;
    private int $quantity;

    public function __construct(string $month_label, int $month_value, int $quantity)
    {
        $this->month_label = $month_label;
        $this->month_value = $month_value;
        $this->quantity = $quantity;
    }

    public function getMonthLabel(): string
    {
        return $this->month_label;
    }

    public function getMonthValue(): int
    {
        return $this->month_value;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function toArray(): array
    {
        return [
            'month_label' => $this->month_label,
            'month_value' => $this->month_value,
            'quantity'  => $this->quantity
        ];
    }

    public static function fromArray($array): self
    {
        return new self($array['month_label'], $array['month_value'], $array['quantity']);
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
}


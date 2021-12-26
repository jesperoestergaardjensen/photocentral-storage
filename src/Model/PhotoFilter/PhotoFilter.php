<?php

namespace PhotoCentralStorage\Model\PhotoFilter;

interface PhotoFilter
{
    public function toArray(): array;

    public static function fromArray($array, $return_class_override = self::class): PhotoFilter;
}

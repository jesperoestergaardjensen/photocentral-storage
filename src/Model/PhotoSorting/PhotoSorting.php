<?php

namespace PhotoCentralStorage\Model\PhotoSorting;

interface PhotoSorting
{
    public function toArray(): array;

    public static function fromArray($array, $return_class_override = self::class): PhotoSorting;

}
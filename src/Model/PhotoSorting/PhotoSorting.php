<?php

namespace PhotoCentralStorage\Model\PhotoSorting;

use PhotoCentralStorage\Photo;

interface PhotoSorting
{
    public function toArray(): array;

    public static function fromArray($array, string $return_class_override = self::class): PhotoSorting;

    /**
     * @param Photo[] $unsorted_photo_list
     *
     * @return Photo[]
     */
    public function sort(array $unsorted_photo_list): array;
}
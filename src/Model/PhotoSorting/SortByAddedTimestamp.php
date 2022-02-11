<?php

namespace PhotoCentralStorage\Model\PhotoSorting;

use PhotoCentralStorage\Photo;

/**
 * @see Photo::getPhotoAddedDateTime()
 */
class SortByAddedTimestamp extends BasicSorting implements PhotoSorting
{
    public function sort(array $unsorted_photo_list): array
    {
        if ($this->getDirection() === BasicSorting::ASC) {
            usort($unsorted_photo_list, fn(Photo $a, Photo $b) => ($a->getPhotoAddedDateTime()) > ($b->getPhotoAddedDateTime()));
        } else {
            usort($unsorted_photo_list, fn(Photo $a, Photo $b) => ($a->getPhotoAddedDateTime()) < ($b->getPhotoAddedDateTime()));
        }

        // Return now sorted list
        return $unsorted_photo_list;
    }

    public static function fromArray($array, $return_class_override = self::class): PhotoSorting
    {
        return new $return_class_override($array[self::ARRAY_KEY_DIRECTION]);
    }
}

<?php

namespace PhotoCentralStorage\Model\PhotoSorting;

use PhotoCentralStorage\Photo;

/**
 * @see Photo::getPhotoDateTime()
 */
class SortByPhotoDateTime extends BasicSorting implements PhotoSorting
{
    public function sort(array $unsorted_photo_list): array
    {
        if ($this->getDirection() === BasicSorting::ASC) {
            uasort($unsorted_photo_list, fn(Photo $a, Photo $b) => ($a->getPhotoDateTime()) > ($b->getPhotoDateTime()));
        } else {
            uasort($unsorted_photo_list, fn(Photo $a, Photo $b) => ($a->getPhotoDateTime()) < ($b->getPhotoDateTime()));
        }

        // Return now sorted list
        return $unsorted_photo_list;
    }
}

<?php

namespace PhotoCentralStorage\Model\PhotoSorting;

use PhotoCentralStorage\Photo;

/**
 * @deprecated Do not make sense anymore. Use SortByPhotoDateTime instead
 */
class SortByCreatedTimestamp extends BasicSorting implements PhotoSorting
{
    public function sort(array $unsorted_photo_list): array
    {
        return $unsorted_photo_list;
    }
}

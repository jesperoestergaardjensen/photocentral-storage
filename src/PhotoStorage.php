<?php

namespace PhotoCentralStorage;

use PhotoCentralStorage\Model\ImageDimensions;
use PhotoCentralStorage\Model\PhotoFilter\PhotoFilter;
use PhotoCentralStorage\Model\PhotoSorting\PhotoSorting;

interface PhotoStorage
{
    /**
     * @param string $search_string
     *
     * @return Photo[]
     */
    public function searchPhotos(string $search_string): array;

    /**
     * @param PhotoFilter[]|null $photo_filters
     * @param PhotoSorting|null  $photo_sorting
     * @param int                $limit
     *
     * @return Photo[]
     */
    public function listPhotos(array $photo_filters = null, PhotoSorting $photo_sorting = null, int $limit = 5): array;

    public function getPhoto(string $photo_uuid): Photo;

    /**
     * @deprecated Use listPhotos with PhotoUuidFilter instead
     *
     * @param array $photo_uuid_list
     *
     * @return Photo[]
     */
    public function getPhotos(array $photo_uuid_list): array;

    public function softDeletePhoto(string $photo_uuid): bool;

    public function undoSoftDeletePhoto(string $photo_uuid): bool;

    /**
     * @param int $limit
     *
     * @return PhotoCollection[]
     */
    public function listPhotoCollections(int $limit): array;

    public function getPhotoPath(string $photo_uuid, ImageDimensions $image_dimensions): string;
}
<?php

namespace PhotoCentralStorage;

use PhotoCentralStorage\Model\ImageDimensions;
use PhotoCentralStorage\Model\PhotoFilter\PhotoFilter;
use PhotoCentralStorage\Model\PhotoSorting\PhotoSorting;

interface PhotoCentralStorage
{
    /**
     * @param string $search_string
     * @param array  $photo_collection_id_list
     * @param int    $limit
     *
     * @return Photo[]
     */
    public function searchPhotos(string $search_string, array $photo_collection_id_list, int $limit = 10): array;

    /**
     * @param PhotoFilter[]|null $photo_filters
     * @param PhotoSorting|null  $photo_sorting
     * @param int                $limit
     *
     * @return Photo[]
     */
    public function listPhotos(array $photo_filters = null, PhotoSorting $photo_sorting = null, int $limit = 5): array;

    public function getPhoto(string $photo_uuid, string $photo_collection_id): Photo;

    public function softDeletePhoto(string $photo_uuid): bool;

    public function undoSoftDeletePhoto(string $photo_uuid): bool;

    /**
     * @param int $limit
     *
     * @return PhotoCollection[]
     */
    public function listPhotoCollections(int $limit): array;

    public function getPhotoPath(string $photo_uuid, string $photo_collection_id, ImageDimensions $image_dimensions): string;
}
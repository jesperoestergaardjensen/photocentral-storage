<?php

namespace PhotoCentralStorage;

use PhotoCentralStorage\Model\ImageDimensions;

interface PhotoStorage
{
    /**
     * @param string $search_string
     *
     * @return Photo[]
     */
    public function searchPhotos(string $search_string): array;

    /**
     * @param int        $start_unix_timestamp
     * @param int        $end_unix_timestamp
     * @param            $order_by
     * @param int        $limit
     * @param array|null $photo_collection_filter_uuid_list
     *
     * @return Photo[]
     */
    public function listPhotos(int $start_unix_timestamp, int $end_unix_timestamp, $order_by, int $limit, array $photo_collection_filter_uuid_list = null): array;

    public function getPhoto(string $photo_uuid): Photo;

    /**
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
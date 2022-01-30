<?php

namespace PhotoCentralStorage;

use PhotoCentralStorage\Model\ImageDimensions;
use PhotoCentralStorage\Model\PhotoFilter\PhotoFilter;
use PhotoCentralStorage\Model\PhotoQuantity\PhotoQuantityDay;
use PhotoCentralStorage\Model\PhotoQuantity\PhotoQuantityMonth;
use PhotoCentralStorage\Model\PhotoQuantity\PhotoQuantityYear;
use PhotoCentralStorage\Model\PhotoSorting\PhotoSorting;

interface PhotoCentralStorage
{
    /**
     * @param string     $search_string
     * @param array|null $photo_collection_id_list
     * @param int        $limit
     *
     * @return Photo[]
     */
    public function searchPhotos(string $search_string, ?array $photo_collection_id_list, int $limit = 10): array;

    /**
     * @param ?PhotoFilter[]  $photo_filters
     * @param ?PhotoSorting[] $photo_sorting_parameters
     * @param int             $limit
     *
     * @return Photo[]
     */
    public function listPhotos(
        array $photo_filters = null,
        array $photo_sorting_parameters = null,
        int $limit = 5
    ): array;

    public function getPhoto(string $photo_uuid, string $photo_collection_id): Photo;

    public function softDeletePhoto(string $photo_uuid): bool;

    public function undoSoftDeletePhoto(string $photo_uuid): bool;

    /**
     * @param int $limit
     *
     * @return PhotoCollection[]
     */
    public function listPhotoCollections(int $limit): array;

    public function getPathOrUrlToPhoto(
        string $photo_uuid,
        ImageDimensions $image_dimensions,
        string $photo_collection_id
    ): string;

    public function getPathOrUrlToCachedPhoto(
        string $photo_uuid,
        ImageDimensions $image_dimensions,
        string $photo_collection_id
    ): string;

    public function setPhotoCache(?string $photo_cache_path): void;

    public function getPhotoCache(): ?string;

    /**
     * @param ?array $photo_collection_id_list
     *
     * @return PhotoQuantityYear[]
     */
    public function listPhotoQuantityByYear(?array $photo_collection_id_list): array;

    /**
     * @param int    $year
     * @param ?array $photo_collection_id_list
     *
     * @return PhotoQuantityMonth[]
     */
    public function listPhotoQuantityByMonth(int $year, ?array $photo_collection_id_list): array;

    /**
     * @param int        $month
     * @param int        $year
     * @param ?array $photo_collection_id_list
     *
     * @return PhotoQuantityDay[]
     */
    public function listPhotoQuantityByDay(int $month, int $year, ?array $photo_collection_id_list): array;
}
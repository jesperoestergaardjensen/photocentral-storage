<?php

namespace PhotoCentralStorage;

use PhotoCentralStorage\Exception\PhotoCentralStorageException;
use PhotoCentralStorage\Model\ImageDimensions;

/**
 * Use this class if you want to combine multiple photo central storage types - the hub will act as one combined photo central storage
 */
// TODO - Open question...can we handle different cache path's ??
class PhotoCentralStorageHub implements PhotoCentralStorage
{
    /**
     * @var PhotoCentralStorage[]
     */
    private array $photo_central_storage_list = [];

    private bool $initialized = false;

    private array $photo_collection_to_storage_map = [];

    private ?string $photo_cache;

    public function __construct(array $photo_central_storage_list)
    {
        $this->photo_central_storage_list = $photo_central_storage_list;
    }

    public function initialize()
    {
        // TODO : Maybe initialize should handle that all have the same cache path?
        // TODO : Throw exception if photo collections have the same id
        foreach ($this->photo_central_storage_list as $index => $photo_central_storage) {
            $photo_collection_list = $photo_central_storage->listPhotoCollections(1000);

            foreach ($photo_collection_list as $photo_collection) {
                $this->photo_collection_to_storage_map[$photo_collection->getId()] = $index;
            }
        }
    }

    public function searchPhotos(string $search_string, ?array $photo_collection_id_list, int $limit = 10): array
    {
        $this->throwExceptionIfNotInitialized();

        $merged_search_result_list = [];
        foreach ($this->photo_central_storage_list as $photo_central_storage) {
            $search_result_list = $photo_central_storage->searchPhotos($search_string, $photo_collection_id_list, $limit);
            $merged_search_result_list = array_merge($merged_search_result_list, $search_result_list);
        }

        return array_slice($merged_search_result_list, 0, $limit);
    }

    public function listPhotos(
        array $photo_filters = null,
        array $photo_sorting_parameters = null,
        int $limit = 5
    ): array {
        $this->throwExceptionIfNotInitialized();
    }

    public function getPhoto(string $photo_uuid, string $photo_collection_id): Photo
    {
        $this->throwExceptionIfNotInitialized();

        $index = $this->photo_collection_to_storage_map[$photo_collection_id];
        return $this->photo_central_storage_list[$index]->getPhoto($photo_uuid, $photo_collection_id);
    }

    public function softDeletePhoto(string $photo_uuid): bool
    {
        $this->throwExceptionIfNotInitialized();

        foreach ($this->photo_central_storage_list as $photo_central_storage) {
            if ($photo_central_storage->softDeletePhoto($photo_uuid) === true) {
                return true;
            }
        }

        return false;
    }

    public function undoSoftDeletePhoto(string $photo_uuid): bool
    {
        $this->throwExceptionIfNotInitialized();

        foreach ($this->photo_central_storage_list as $photo_central_storage) {
            if ($photo_central_storage->undoSoftDeletePhoto($photo_uuid) === true) {
                return true;
            }
        }

        return false;
    }

    public function listPhotoCollections(int $limit): array
    {
        $this->throwExceptionIfNotInitialized();

        $merged_photo_collection_list = [];

        foreach ($this->photo_central_storage_list as $photo_central_storage) {
            $photo_collection_list = $photo_central_storage->listPhotoCollections(1000);
            $merged_photo_collection_list = array_merge($merged_photo_collection_list, $photo_collection_list);
        }

        return $merged_photo_collection_list;
    }

    public function getPathOrUrlToPhoto(
        string $photo_uuid,
        ImageDimensions $image_dimensions,
        string $photo_collection_id
    ): string {
        $this->throwExceptionIfNotInitialized();

        $index = $this->photo_collection_to_storage_map[$photo_collection_id];
        return $this->photo_central_storage_list[$index]->getPathOrUrlToPhoto($photo_uuid, $image_dimensions, $photo_collection_id);
    }

    public function getPathOrUrlToCachedPhoto(
        string $photo_uuid,
        ImageDimensions $image_dimensions,
        string $photo_collection_id
    ): string {
        $this->throwExceptionIfNotInitialized();

        $index = $this->photo_collection_to_storage_map[$photo_collection_id];
        return $this->photo_central_storage_list[$index]->getPathOrUrlToCachedPhoto($photo_uuid, $image_dimensions, $photo_collection_id);
    }

    public function setPhotoCache(?string $photo_cache_path): void
    {
        $this->photo_cache = $photo_cache_path;
    }

    public function getPhotoCache(): ?string
    {
        return $this->photo_cache;
    }

    private function throwExceptionIfNotInitialized(): void
    {
        if ($this->initialized === false) {
            throw new PhotoCentralStorageException('Please call the initialize() method before usage of the PhotoCentralStorageHub class');
        }
    }
}
<?php

namespace PhotoCentralStorage;

use PhotoCentralStorage\Exception\PhotoCentralStorageException;
use PhotoCentralStorage\Model\ImageDimensions;
use PhotoCentralStorage\Model\PhotoQuantity\PhotoQuantityDay;
use PhotoCentralStorage\Model\PhotoQuantity\PhotoQuantityMonth;
use PhotoCentralStorage\Model\PhotoQuantity\PhotoQuantityYear;
use PhotoCentralStorage\Model\PhotoSorting\PhotoSorting;

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

    private ?string $photo_cache = null;

    public function __construct(array $photo_central_storage_list)
    {
        $this->photo_central_storage_list = $photo_central_storage_list;
    }

    /**
     * @throws PhotoCentralStorageException
     */
    public function initialize()
    {
        // TODO : Maybe initialize should handle that all have the same cache path?
        foreach ($this->photo_central_storage_list as $index => $photo_central_storage) {
            $photo_collection_list = $photo_central_storage->listPhotoCollections(1000);

            foreach ($photo_collection_list as $photo_collection) {
                if (array_key_exists($photo_collection->getId(), $this->photo_collection_to_storage_map)) {
                    throw new PhotoCentralStorageException('Duplicate photo collections id ' .$photo_collection->getId());
                }

                $this->photo_collection_to_storage_map[$photo_collection->getId()] = $index;
            }
        }

        $this->initialized = true;
    }

    public function searchPhotos(string $search_string, ?array $photo_collection_id_list, int $limit = 10): array
    {
        $this->throwExceptionIfNotInitialized();

        $merged_search_result_list = [];
        foreach ($this->photo_central_storage_list as $photo_central_storage) {
            $search_result_list = $photo_central_storage->searchPhotos($search_string, $photo_collection_id_list,
                $limit);
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

        $merged_photo_list = [];

        foreach ($this->photo_central_storage_list as $photo_central_storage) {
            $photo_collection_list = $photo_central_storage->listPhotos($photo_filters, $photo_sorting_parameters,
                $limit);
            $merged_photo_list = array_merge($merged_photo_list, $photo_collection_list);
        }

        if ($photo_sorting_parameters) {
            $merged_photo_list = $this->sortPhotoList($photo_sorting_parameters, $merged_photo_list);
        }

        return array_slice($merged_photo_list, 0, $limit);
    }

    /**
     * @param ?PhotoSorting[] $photo_sorting_parameters
     * @param Photo[]         $photo_list
     *
     * @return array
     */
    private function sortPhotoList(?array $photo_sorting_parameters, array $photo_list): array
    {
        foreach ($photo_sorting_parameters as $photo_sorting_parameter) {
            $photo_list = $photo_sorting_parameter->sort($photo_list);
        }

        return $photo_list;
    }

    public function getPhoto(string $photo_uuid, string $photo_collection_id): Photo
    {
        $this->throwExceptionIfNotInitialized();

        if (array_key_exists($photo_collection_id, $this->photo_collection_to_storage_map)) {
            $index = $this->photo_collection_to_storage_map[$photo_collection_id];
        } else {
            throw new PhotoCentralStorageException("Photo collection with id $photo_collection_id not found");
        }

        return $this->photo_central_storage_list[$index]->getPhoto($photo_uuid, $photo_collection_id);
    }

    public function softDeletePhoto(string $photo_uuid): bool
    {
        $this->throwExceptionIfNotInitialized();

        $soft_deleted = false;

        foreach ($this->photo_central_storage_list as $photo_central_storage) {
            if ($photo_central_storage->softDeletePhoto($photo_uuid) === true) {
                $soft_deleted = true;
            }
        }

        return $soft_deleted;
    }

    public function undoSoftDeletePhoto(string $photo_uuid): bool
    {
        $this->throwExceptionIfNotInitialized();

        $undo_soft_deleted = false;

        foreach ($this->photo_central_storage_list as $photo_central_storage) {
            if ($photo_central_storage->undoSoftDeletePhoto($photo_uuid) === true) {
                $undo_soft_deleted = true;
            }
        }

        return $undo_soft_deleted;
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

        return $this->photo_central_storage_list[$index]->getPathOrUrlToPhoto($photo_uuid, $image_dimensions,
            $photo_collection_id);
    }

    public function getPathOrUrlToCachedPhoto(
        string $photo_uuid,
        ImageDimensions $image_dimensions,
        string $photo_collection_id
    ): string {
        $this->throwExceptionIfNotInitialized();

        $index = $this->photo_collection_to_storage_map[$photo_collection_id];

        return $this->photo_central_storage_list[$index]->getPathOrUrlToCachedPhoto($photo_uuid, $image_dimensions,
            $photo_collection_id);
    }

    public function setPhotoCache(?string $photo_cache_path): void
    {
        $this->photo_cache = $photo_cache_path;
    }

    public function getPhotoCache(): ?string
    {
        return $this->photo_cache;
    }

    /**
     * @throws PhotoCentralStorageException
     */
    private function throwExceptionIfNotInitialized(): void
    {
        if ($this->initialized === false) {
            throw new PhotoCentralStorageException('Please call the initialize() method before usage of the PhotoCentralStorageHub class');
        }
    }

    public function listPhotoQuantityByYear(?array $photo_collection_id_list): array
    {
        $merged_year_quantity_list = [];

        foreach ($this->photo_central_storage_list as $photo_central_storage) {
            $year_quantity_list = $photo_central_storage->listPhotoQuantityByYear($photo_collection_id_list);
            $merged_year_quantity_list = $this->mergeYearQuantityLists($merged_year_quantity_list, $year_quantity_list);
        }

        usort($merged_year_quantity_list, fn(PhotoQuantityYear $a, PhotoQuantityYear $b) => ($a->getYearValue()) < ($b->getYearValue()));
        return $merged_year_quantity_list;
    }

    /**
     * @param PhotoQuantityYear[] $merged_year_quantity_list
     * @param PhotoQuantityYear[] $year_quantity_list
     *
     * @return PhotoQuantityYear[]
     */
    private function mergeYearQuantityLists(array $merged_year_quantity_list, array $year_quantity_list): array
    {
        foreach ($year_quantity_list as $quantity_year) {
            foreach ($merged_year_quantity_list as $merged_year_quantity) {
                if ($quantity_year->getYearValue() === $merged_year_quantity->getYearValue()) {
                    $merged_year_quantity->setQuantity($quantity_year->getQuantity()+$merged_year_quantity->getQuantity());
                    continue(2);
                }
            }
            $merged_year_quantity_list[] = $quantity_year;
        }
        return $merged_year_quantity_list;
    }

    public function listPhotoQuantityByMonth(int $year, ?array $photo_collection_id_list): array
    {
        $merged_month_quantity_list = [];

        foreach ($this->photo_central_storage_list as $photo_central_storage) {
            $month_quantity_list = $photo_central_storage->listPhotoQuantityByMonth($year, $photo_collection_id_list);
            $merged_month_quantity_list = $this->mergeMonthQuantityLists($merged_month_quantity_list, $month_quantity_list);
        }

        usort($merged_month_quantity_list, fn(PhotoQuantityMonth $a, PhotoQuantityMonth $b) => ($a->getMonthValue()) > ($b->getMonthValue()));
        return $merged_month_quantity_list;
    }

    /**
     * @param PhotoQuantityMonth[] $merged_month_quantity_list
     * @param PhotoQuantityMonth[] $month_quantity_list
     *
     * @return PhotoQuantityMonth[]
     */
    private function mergeMonthQuantityLists(array $merged_month_quantity_list, array $month_quantity_list): array
    {
        foreach ($month_quantity_list as $quantity_month) {
            foreach ($merged_month_quantity_list as $merged_month_quantity) {
                if ($quantity_month->getMonthValue() === $merged_month_quantity->getMonthValue()) {
                    $merged_month_quantity->setQuantity($quantity_month->getQuantity()+$merged_month_quantity->getQuantity());
                    continue(2);
                }
            }
            $merged_month_quantity_list[] = $quantity_month;
        }
        return $merged_month_quantity_list;
    }


    public function listPhotoQuantityByDay(int $month, int $year, ?array $photo_collection_id_list): array
    {
        $merged_day_quantity_list = [];

        foreach ($this->photo_central_storage_list as $photo_central_storage) {
            $day_quantity_list = $photo_central_storage->listPhotoQuantityByDay($month, $year, $photo_collection_id_list);
            $merged_day_quantity_list = $this->mergeDayQuantityLists($merged_day_quantity_list, $day_quantity_list);
        }

        usort($merged_day_quantity_list, fn(PhotoQuantityDay $a, PhotoQuantityDay $b) => ($a->getDayValue()) > ($b->getDayValue()));
        return $merged_day_quantity_list;
    }

    /**
     * @param PhotoQuantityDay[] $merged_month_quantity_list
     * @param PhotoQuantityDay[] $month_quantity_list
     *
     * @return PhotoQuantityDay[]
     */
    private function mergeDayQuantityLists(array $merged_month_quantity_list, array $month_quantity_list): array
    {
        foreach ($month_quantity_list as $quantity_month) {
            foreach ($merged_month_quantity_list as $merged_month_quantity) {
                if ($quantity_month->getDayValue() === $merged_month_quantity->getDayValue()) {
                    $merged_month_quantity->setQuantity($quantity_month->getQuantity()+$merged_month_quantity->getQuantity());
                    continue(2);
                }
            }
            $merged_month_quantity_list[] = $quantity_month;
        }
        return $merged_month_quantity_list;
    }
}

<?php

namespace PhotoCentralStorage\Tests\Unit;

use PhotoCentralSimpleLinuxStorage\SimpleLinuxStorage;
use PhotoCentralStorage\Exception\PhotoCentralStorageException;
use PhotoCentralStorage\Model\PhotoQuantity\PhotoQuantityDay;
use PhotoCentralStorage\Model\PhotoQuantity\PhotoQuantityMonth;
use PhotoCentralStorage\Model\PhotoQuantity\PhotoQuantityYear;
use PhotoCentralStorage\PhotoCentralStorage;
use PhotoCentralStorage\PhotoCentralStorageHub;
use PhotoCentralStorage\PhotoCollection;
use PhotoCentralStorage\Tests\UUIDService;

class PhotoCentralStorageHubTest extends PhotoCentralStorageTestBase
{
    public function initializePhotoCentralStorage(): PhotoCentralStorage
    {
        $simple_linux_storage = new SimpleLinuxStorage($this->getPhotosTestFolder() . 'storage1/',
            $this->getImageCacheTestFolder());
        $simple_linux_storage_second = new SimpleLinuxStorage($this->getPhotosTestFolder() . 'storage2/',
            $this->getImageCacheTestFolder(), '727a8cdc-2275-4b54-942c-3295b2e300e2');

        return new PhotoCentralStorageHub([$simple_linux_storage, $simple_linux_storage_second]);
    }

    public function setupExpectedProperties()
    {
        $this->expected_photo_colletion_list = [
            new PhotoCollection(SimpleLinuxStorage::getDefaultPhotoCollectionUuid(), 'Photo folder', true,
                "Simple Linux Storage folder (" . $this->getPhotosTestFolder() . "storage1/)", null),
            new PhotoCollection('727a8cdc-2275-4b54-942c-3295b2e300e2', 'Photo folder', true,
                "Simple Linux Storage folder (" . $this->getPhotosTestFolder() . "storage2/)", null),
        ];

        $this->expected_list_photos_photo_uuid_list = [
            'fd03f50cb54942882bcdcc4e6b5fffe5',
            'c9d9287f153e87b4f83cdea7f32db649',
        ];

        $this->expected_search_string = 'bike';
        $this->expected_photo_uuid_for_get = '6d1858ef4ee6897f18fc0d0381d92c7d';
        $this->expected_photo_uuid_list_for_search = [
            'c9d9287f153e87b4f83cdea7f32db649',
            'c9d9287f153e87b4f83cdea7f32db649',
        ];
        $this->expected_photo_uuid_for_soft_delete = 'fd03f50cb54942882bcdcc4e6b5fffe5';
        $this->expected_photo_quantity_by_year_list = [
            new PhotoQuantityYear('2022', 2022, 2),
            new PhotoQuantityYear('2019', 2019, 2),
            new PhotoQuantityYear('2017', 2017, 2),
        ];

        $this->expected_photo_quantity_by_month_list = [
            new PhotoQuantityMonth('02', 2, 2),
        ];
        $this->expected_photo_quantity_by_day_list = [
            new PhotoQuantityDay('11', 11, 2),
        ];

        $this->expected_non_existing_photo_uuid = UUIDService::create();
    }

    public function setUp(): void
    {
        $this->photo_central_storage = $this->initializePhotoCentralStorage();
        $this->photo_central_storage->initialize();
        $this->setupExpectedProperties();
    }

    public function testThrowExceptionIfNotInitialized()
    {
        $simple_linux_storage = new SimpleLinuxStorage($this->getPhotosTestFolder() . 'storage1/',
            $this->getImageCacheTestFolder());

        $hub = new PhotoCentralStorageHub([$simple_linux_storage]);

        $this->expectException(PhotoCentralStorageException::class);
        $hub->listPhotoCollections(10);
    }

    public function testDuplicatePhotoCollectionUuid(): void
    {
        $simple_linux_storage = new SimpleLinuxStorage($this->getPhotosTestFolder(),
            $this->getImageCacheTestFolder());

        $storage = new PhotoCentralStorageHub([$simple_linux_storage, $simple_linux_storage]);
        $this->expectException(PhotoCentralStorageException::class);
        $storage->initialize();
    }

    private function getPhotosTestFolder(): string
    {
        return dirname(__DIR__) . "/data/storage-hub/photos/";
    }

    private function getImageCacheTestFolder(): string
    {
        return dirname(__DIR__) . "/data/storage-hub/cache/";
    }
}

<?php

namespace PhotoCentralStorage\Tests\Unit;

use PhotoCentralSimpleLinuxStorage\SimpleLinuxStorage;
use PhotoCentralStorage\Exception\PhotoCentralStorageException;
use PhotoCentralStorage\Model\PhotoQuantity\PhotoQuantityDay;
use PhotoCentralStorage\Model\PhotoQuantity\PhotoQuantityMonth;
use PhotoCentralStorage\Model\PhotoQuantity\PhotoQuantityYear;
use PhotoCentralStorage\PhotoCentralStorageHub;

class PhotoCentralStorageHubTest extends \PHPUnit\Framework\TestCase
{
    private PhotoCentralStorageHub $storage_hub;

    private const DELETED_PHOTO_UUID_1 = 'e9be5e89fc397c680580599e1f3ef21e';
    private const DELETED_PHOTO_UUID_2 = '8fae4586a47a2356df0ea12c997e047e';

    private const TEST_PHOTO_FILE_NAME_1 = 'coffee-break.jpg';
    private const TEST_PHOTO_FILE_NAME_2 = 'sport/mtb/mountain-bike-g30008f9d7_1280.jpg';

    private function getPhotosTestFolder(): string
    {
        return dirname(__DIR__) . "/data/storage-hub/photos/";
    }

    private function getImageCacheTestFolder(): string
    {
        return dirname(__DIR__) . "/data/storage-hub/cache/";
    }

    public function setUp(): void
    {
        $simple_linux_storage = new SimpleLinuxStorage($this->getPhotosTestFolder(),
            $this->getImageCacheTestFolder());
        $simple_linux_storage_second = new SimpleLinuxStorage($this->getPhotosTestFolder(),
            $this->getImageCacheTestFolder(), '727a8cdc-2275-4b54-942c-3295b2e300e2');
        $this->storage_hub = new PhotoCentralStorageHub([$simple_linux_storage, $simple_linux_storage_second]);
        $this->storage_hub->initialize();
    }

    public function testDuplicatePhotoCollectionUuid(): void
    {
        $simple_linux_storage = new SimpleLinuxStorage($this->getPhotosTestFolder(),
            $this->getImageCacheTestFolder());

        $storage = new PhotoCentralStorageHub([$simple_linux_storage, $simple_linux_storage]);
        $this->expectException(PhotoCentralStorageException::class);
        $storage->initialize();
    }

    public function testListPhotoCollections()
    {
        $photo_collection_list = $this->storage_hub->listPhotoCollections(2);

        $this->assertCount(2, $photo_collection_list, 'One item in the list is expected');
        $this->assertEquals(SimpleLinuxStorage::getDefaultPhotoCollectionUuid(), $photo_collection_list[0]->getId(), 'id is expected to be ' . SimpleLinuxStorage::getDefaultPhotoCollectionUuid());
        $this->assertEquals('Photo folder', $photo_collection_list[0]->getName(),
            'name is expected to be "Photo folder"');
        $photo_folder = $this->getPhotosTestFolder();
        $this->assertEquals("Simple Linux Storage folder ($photo_folder)", $photo_collection_list[0]->getDescription());
    }

    public function testlistPhotoQuantityByYear()
    {
        $expected = [
            new PhotoQuantityYear('2022',2022, 4),
            new PhotoQuantityYear('2019',2019, 2),
            new PhotoQuantityYear('2017',2017, 2),
        ];

        $actual = $this->storage_hub->listPhotoQuantityByYear([SimpleLinuxStorage::getDefaultPhotoCollectionUuid()]);
        $this->assertEquals($expected, $actual);
    }

    public function testlistPhotoQuantityByMonth()
    {
        $expected = [
            new PhotoQuantityMonth('02',2, 4),
        ];

        $actual = $this->storage_hub->listPhotoQuantityByMonth(2022, [SimpleLinuxStorage::getDefaultPhotoCollectionUuid()]);
        $this->assertEquals($expected, $actual);
    }

    public function testlistPhotoQuantityByDay()
    {
        $expected = [
            new PhotoQuantityDay('11',11, 4),
        ];

        $actual = $this->storage_hub->listPhotoQuantityByDay(2, 2022, [SimpleLinuxStorage::getDefaultPhotoCollectionUuid()]);
        $this->assertEquals($expected, $actual);
    }
}

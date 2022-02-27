<?php

namespace PhotoCentralStorage\Tests\Unit;

use LinuxImageHelper\Model\JpgImage;
use LinuxImageHelper\Service\JpgImageService;
use PhotoCentralStorage\Exception\PhotoCentralStorageException;
use PhotoCentralStorage\Model\ImageDimensions;
use PhotoCentralStorage\Model\PhotoFilter\PhotoCollectionIdFilter;
use PhotoCentralStorage\Photo;
use PhotoCentralStorage\PhotoCentralStorage;
use PhotoCentralStorage\PhotoCollection;
use PhotoCentralStorage\Tests\UUIDService;
use PHPUnit\Framework\TestCase;

abstract class PhotoCentralStorageTestBase extends TestCase implements PhotoCentralStorageTest
{
    protected ?PhotoCentralStorage $photo_central_storage = null;

    /**
     * @var PhotoCollection[]
     */
    protected ?array $expected_photo_colletion_list = null;
    protected ?array $expected_photo_uuid_list_for_search = null;
    protected ?string $expected_search_string = null;
    protected ?string $expected_photo_uuid_for_get = null;
    protected ?string $expected_photo_uuid_for_soft_delete = null;
    protected ?array $expected_photo_quantity_by_year_list = null;
    protected ?array $expected_photo_quantity_by_month_list = null;
    protected ?array $expected_photo_quantity_by_day_list = null;
    protected ?array $expected_list_photos_photo_uuid_list = null;
    protected ?string $expected_non_existing_photo_uuid = null;

    private function preRunTest()
    {
        if ($this->photo_central_storage === null) {
            throw new PhotoCentralStorageException('Please use method initializePhotoCentralStorage to set a Photo Central Storage');
        }

        if (
            $this->expected_non_existing_photo_uuid === null ||
            $this->expected_list_photos_photo_uuid_list === null ||
            $this->expected_search_string === null ||
            $this->expected_photo_uuid_for_get === null ||
            $this->expected_photo_colletion_list === null ||
            $this->expected_photo_uuid_list_for_search === null ||
            $this->expected_photo_uuid_for_soft_delete === null ||
            $this->expected_photo_quantity_by_year_list === null ||
            $this->expected_photo_quantity_by_month_list === null ||
            $this->expected_photo_quantity_by_day_list === null
        ) {
            throw new PhotoCentralStorageException('Please use method setupExpectedProperties to set expected properties');
        }
    }

    public function testSearchPhotos()
    {
        $this->preRunTest();
        $expected_photo_list_for_search = $this->buildPhotoList();
        $search_result = $this->photo_central_storage->searchPhotos($this->expected_search_string, $this->expected_photo_colletion_list, 100);
        $this->assertEquals($expected_photo_list_for_search, $search_result);
    }

    /**
     * @return Photo[]
     */
    private function buildPhotoList(): array
    {
        $expected_photo_list_for_search = [];
        foreach ($this->expected_photo_colletion_list as $expected_photo_collection) {
            foreach ($this->expected_photo_uuid_list_for_search as $photo_uuid) {
                try {
                    $photo = $this->photo_central_storage->getPhoto($photo_uuid, $expected_photo_collection->getId());
                    $expected_photo_list_for_search[$expected_photo_collection->getId().$photo_uuid] = $photo;
                } catch (PhotoCentralStorageException $photo_central_storage_exception) {
                }
            }
        }
        return array_values($expected_photo_list_for_search);
    }

    public function testGetPhoto()
    {
        $this->preRunTest();

        // Test existing photo uuid
        $photo = $this->photo_central_storage->getPhoto($this->expected_photo_uuid_for_get, array_pop($this->expected_photo_colletion_list)->getId());
        $this->assertInstanceOf(Photo::class, $photo);

        // Test non-existing photo uuid
        $this->expectException(PhotoCentralStorageException::class);
        $this->photo_central_storage->getPhoto($this->expected_non_existing_photo_uuid, array_pop($this->expected_photo_colletion_list)->getId());
    }

    public function testlistPhotoQuantityByYear()
    {
        $this->preRunTest();

        $photo_colleciton_id_list = [];
        foreach ($this->expected_photo_colletion_list as $expected_photo_collection) {
            $photo_colleciton_id_list[] = $expected_photo_collection->getId();
        }

        $actual = $this->photo_central_storage->listPhotoQuantityByYear($photo_colleciton_id_list);
        $this->assertEquals($this->expected_photo_quantity_by_year_list, $actual);
    }

    public function testlistPhotoQuantityByMonth()
    {
        $this->preRunTest();

        $expected_photo_collection_id_list = [];
        foreach ($this->expected_photo_colletion_list as $expected_photo_collection) {
            $expected_photo_collection_id_list[] = $expected_photo_collection->getId();
        }

        $actual = $this->photo_central_storage->listPhotoQuantityByMonth(2022, $expected_photo_collection_id_list);
        $this->assertEquals($this->expected_photo_quantity_by_month_list, $actual);
    }

    public function testlistPhotoQuantityByDay()
    {
        $this->preRunTest();

        $expected_photo_collection_id_list = [];
        foreach ($this->expected_photo_colletion_list as $expected_photo_collection) {
            $expected_photo_collection_id_list[] = $expected_photo_collection->getId();
        }

        $actual = $this->photo_central_storage->listPhotoQuantityByDay(2, 2022, $expected_photo_collection_id_list);
        $this->assertEquals($this->expected_photo_quantity_by_day_list, $actual);
    }

    public function testListPhotoCollections()
    {
        $this->preRunTest();

        $photo_collection_list = $this->photo_central_storage->listPhotoCollections(5);

        $this->assertNotEmpty($photo_collection_list);
        $this->assertIsArray($photo_collection_list);

        foreach ($photo_collection_list as $photo_collection) {
            $this->assertInstanceOf(PhotoCollection::class, $photo_collection);
        }

        $this->assertEquals($this->expected_photo_colletion_list, $photo_collection_list);
    }

    public function testSoftDeleteExistingPhoto()
    {
        $this->preRunTest();

        $result = $this->photo_central_storage->softDeletePhoto($this->expected_photo_uuid_for_soft_delete);
        $this->assertTrue($result);
    }
    public function testSoftDeleteNonExistingPhoto() {
        $this->preRunTest();

        $result2 = $this->photo_central_storage->softDeletePhoto($this->expected_non_existing_photo_uuid);
        $this->assertFalse($result2);
    }

    /**
     * @depends testSoftDeleteExistingPhoto
     */
    public function testUndoSoftDeleteExistingPhoto()
    {
        $this->preRunTest();

        $result = $this->photo_central_storage->undoSoftDeletePhoto($this->expected_photo_uuid_for_soft_delete);
        $this->assertTrue($result);
    }

    public function testUndoSoftDeleteNonExistingPhoto()
    {
        $this->preRunTest();

        $result2 = $this->photo_central_storage->undoSoftDeletePhoto($this->expected_non_existing_photo_uuid);
        $this->assertFalse($result2);
    }

    public function testGetPathOrUrlToPhoto()
    {
        $this->preRunTest();

        $photo_path_or_url = $this->photo_central_storage->getPathOrUrlToPhoto($this->expected_photo_uuid_for_get, ImageDimensions::createFromId(ImageDimensions::SD_ID), $this->expected_photo_colletion_list[0]->getId());
        $photo = (new JpgImageService())->createJpg($photo_path_or_url);
        $this->assertInstanceOf(JpgImage::class, $photo);
    }

    public function testGetPathOrUrlToCachedPhoto()
    {
        $this->preRunTest();

        $photo_path_or_url = $this->photo_central_storage->getPathOrUrlToCachedPhoto($this->expected_photo_uuid_for_get, ImageDimensions::createFromId(ImageDimensions::SD_ID), $this->expected_photo_colletion_list[0]->getId());

        str_replace('.jpg', '', $photo_path_or_url, $count);
        $this->assertGreaterThan(0, $count);
        str_replace($this->expected_photo_uuid_for_get, '', $photo_path_or_url, $count);
        $this->assertGreaterThan(0, $count);
        str_replace($this->expected_photo_colletion_list[0]->getId(), '', $photo_path_or_url, $count);
        $this->assertGreaterThan(0, $count);
        str_replace(ImageDimensions::SD_ID, '', $photo_path_or_url, $count);
        $this->assertGreaterThan(0, $count);
    }

    public function testSetAndGetPhotoCache()
    {
        $this->preRunTest();

        $cache = '/this/is/a/test/path';

        $cache_before = $this->photo_central_storage->getPhotoCache();
        $this->assertNotEquals($cache, $cache_before);
        $this->photo_central_storage->setPhotoCache($cache);
        $cache_after = $this->photo_central_storage->getPhotoCache();
        $this->assertEquals($cache, $cache_after);
    }

    public function testListPhotos()
    {
        // TODO : Consider how many tests are needed here since filters are tested individually too

        $this->preRunTest();

        $photo_colleciton_id_list = [];
        foreach ($this->expected_photo_colletion_list as $expected_photo_collection) {
            $photo_colleciton_id_list[] = $expected_photo_collection->getId();
        }

        $photo_list = array_values($this->photo_central_storage->listPhotos([new PhotoCollectionIdFilter($photo_colleciton_id_list)], null, 2));
        $this->assertEquals($this->expected_list_photos_photo_uuid_list, [$photo_list[0]->getPhotoUuid(), $photo_list[1]->getPhotoUuid()]);
    }
}

<?php

namespace PhotoCentralStorage\Tests\Unit;

use PhotoCentralSimpleLinuxStorage\SimpleLinuxStorage;
use PhotoCentralStorage\Exception\PhotoCentralStorageException;
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

    private function preRunTest()
    {
        if ($this->photo_central_storage === null) {
            throw new PhotoCentralStorageException('Please use method initializePhotoCentralStorage to set a Photo Central Storage');
        }

        if (
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
        $non_existing_photo_uuid = UUIDService::create();
        $this->expectException(PhotoCentralStorageException::class);
        $this->photo_central_storage->getPhoto($non_existing_photo_uuid, array_pop($this->expected_photo_colletion_list)->getId());
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
        $actual = $this->photo_central_storage->listPhotoQuantityByMonth(2022, [SimpleLinuxStorage::getDefaultPhotoCollectionUuid()]);
        $this->assertEquals($this->expected_photo_quantity_by_month_list, $actual);
    }

    public function testlistPhotoQuantityByDay()
    {
        $this->preRunTest();
        $actual = $this->photo_central_storage->listPhotoQuantityByDay(2, 2022, [SimpleLinuxStorage::getDefaultPhotoCollectionUuid()]);
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

    public function testSoftDeletePhoto()
    {
        $this->preRunTest();

        $non_existing_photo_uuid = UUIDService::create();
        $result = $this->photo_central_storage->softDeletePhoto($this->expected_photo_uuid_for_soft_delete);
        $this->assertTrue($result);
        $result2 = $this->photo_central_storage->softDeletePhoto($non_existing_photo_uuid);
        $this->assertFalse($result2);
    }

    /**
     * @depends testSoftDeletePhoto
     */
    public function testUndoSoftDeletePhoto()
    {
        $this->preRunTest();

        $non_existing_photo_uuid = UUIDService::create();
        $result = $this->photo_central_storage->undoSoftDeletePhoto($this->expected_photo_uuid_for_soft_delete);
        $this->assertTrue($result);
        $result2 = $this->photo_central_storage->undoSoftDeletePhoto($non_existing_photo_uuid);
        $this->assertFalse($result2);
    }
}

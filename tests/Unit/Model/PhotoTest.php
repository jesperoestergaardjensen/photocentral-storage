<?php

namespace PhotoCentralStorage\Tests\Unit\Model;

use PhotoCentralStorage\Exception\PhotoCentralStorageException;
use PhotoCentralStorage\Photo;
use PHPUnit\Framework\TestCase;

class PhotoTest extends TestCase
{
    private string $photo_uuid = '432v4v4';
    private string $photo_collection_id = 'id';
    private int $width = 123;
    private int $height = 345;
    private int $orientation = 1;
    private int $photo_added_date_time = 1641078581;
    private ?int $exif_date_time = 1641088581;
    private ?int $file_system_date_time = 1640078581;
    private ?int $override_date_time = null;
    private ?string $camera_brand = 'Nikon';
    private ?string $camera_model = 'Z77';

    public function testConstructorException() {

        $this->expectException(PhotoCentralStorageException::class);

        new Photo(
            $this->photo_uuid,
            $this->photo_collection_id,
            $this->width,
            $this->height,
            $this->orientation,
            $this->photo_added_date_time,
            null,
            null,
            null,
            $this->camera_brand,
            $this->camera_model
        );
    }

    public function testConstructorAndGetMethods()
    {
        $photo = new Photo(
            $this->photo_uuid,
            $this->photo_collection_id,
            $this->width,
            $this->height,
            $this->orientation,
            $this->photo_added_date_time,
            $this->exif_date_time,
            $this->file_system_date_time,
            $this->override_date_time,
            $this->camera_brand,
            $this->camera_model
        );

        $this->assertEquals($this->photo_uuid, $photo->getPhotoUuid(), 'correct photo uuid value is set and read');
        $this->assertEquals($this->photo_collection_id, $photo->getPhotoCollectionId(), 'correct photo collection id value is set and read');
        $this->assertEquals($this->width, $photo->getWidth(), 'correct width value is set and read');
        $this->assertEquals($this->height, $photo->getHeight(), 'correct height value is set and read');
        $this->assertEquals($this->orientation, $photo->getOrientation(), 'correct orientation value is set and read');
        $this->assertEquals($this->photo_added_date_time, $photo->getPhotoAddedDateTime(), 'correct photo_added_date_time value is set and read');
        $this->assertEquals($this->exif_date_time, $photo->getExifDateTime(), 'correct exif_date_time value is set and read');
        $this->assertEquals($this->file_system_date_time, $photo->getFileSystemDateTime(), 'correct file_system_date_time value is set and read');
        $this->assertEquals($this->override_date_time, $photo->getOverrideDateTime(), 'correct override_date_time value is set and read');
        $this->assertEquals($this->camera_brand, $photo->getCameraBrand(), 'correct camera brand value is set and read');
        $this->assertEquals($this->camera_model, $photo->getCameraModel(), 'correct camera model value is set and read');

        $expected_photo_date_time = $photo->getOverrideDateTime() ?? $photo->getExifDateTime() ?? $photo->getOverrideDateTime();

        $this->assertEquals($expected_photo_date_time, $photo->getPhotoDateTime(), 'correct photo date time value is set and read');
        $this->assertEquals('N/A', $photo->getPhotoUrl(), 'photo url is set to N/A when constructed');
    }

    public function testFromArrayAndToArrayMethods()
    {
        $photo = new Photo(
            $this->photo_uuid,
            $this->photo_collection_id,
            $this->width,
            $this->height,
            $this->orientation,
            $this->photo_added_date_time,
            $this->exif_date_time,
            $this->file_system_date_time,
            $this->override_date_time,
            $this->camera_brand,
            $this->camera_model
        );

        $expected = $photo;
        $actual = Photo::fromArray($photo->toArray());

        $this->assertEquals($expected, $actual, 'fromArray and toArray methods work correctly');
    }

    public function testJsonSerialize()
    {
        $photo = new Photo(
            $this->photo_uuid,
            $this->photo_collection_id,
            $this->width,
            $this->height,
            $this->orientation,
            $this->photo_added_date_time,
            $this->exif_date_time,
            $this->file_system_date_time,
            $this->override_date_time,
            $this->camera_brand,
            $this->camera_model
        );

        $expected = json_encode($photo->toArray());
        $actual = json_encode($photo);

        $this->assertEquals($expected, $actual, 'json serialize is correct inmplemented');
    }

    public function testSetOverideMethod()
    {
        $photo = new Photo(
            $this->photo_uuid,
            $this->photo_collection_id,
            $this->width,
            $this->height,
            $this->orientation,
            $this->photo_added_date_time,
            $this->exif_date_time,
            $this->file_system_date_time,
            $this->override_date_time,
            $this->camera_brand,
            $this->camera_model
        );

        $this->assertNull($photo->getOverrideDateTime(), 'override is empty from beginning in this test');

        $override_date_time = 1444444444;

        $photo->setOverrideDateTime($override_date_time);

        $this->assertEquals($override_date_time, $photo->getOverrideDateTime(), 'set override works');

        $photo = new Photo(
            $this->photo_uuid,
            $this->photo_collection_id,
            $this->width,
            $this->height,
            $this->orientation,
            $this->photo_added_date_time,
            null,
            null,
            $override_date_time,
            $this->camera_brand,
            $this->camera_model
        );

        $this->expectException(PhotoCentralStorageException::class);
        $photo->setOverrideDateTime(null);
    }
}

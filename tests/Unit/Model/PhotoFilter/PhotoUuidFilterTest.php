<?php

namespace PhotoCentralStorage\Tests\Unit\Model\PhotoFilter;

use PhotoCentralStorage\Model\PhotoFilter\AddedTimestampRangeFilter;
use PhotoCentralStorage\Model\PhotoFilter\PhotoCollectionIdFilter;
use PhotoCentralStorage\Model\PhotoFilter\PhotoUuidFilter;
use PHPUnit\Framework\TestCase;

class PhotoUuidFilterTest extends TestCase
{
    public function testToArray()
    {
        $photo_uuid_list = ['a24e57e0-a1e9-4d8e-a671-67eb165a6b1d', 'b24e57e0-a1e9-4d8e-a671-67eb165a6b1d', 'c24e57e0-a1e9-4d8e-a671-67eb165a6b1d'];

        $filter = new PhotoUuidFilter($photo_uuid_list);
        $filter_as_array = $filter->toArray();

        $this->assertEquals($filter->getPhotoUuidList(), $filter_as_array[PhotoUuidFilter::ARRAY_KEY_PHOTO_UUID_LIST]);
    }

    public function testFromArray()
    {
        $photo_uuid_list = ['a24e57e0-a1e9-4d8e-a671-67eb165a6b1d', 'b24e57e0-a1e9-4d8e-a671-67eb165a6b1d', 'c24e57e0-a1e9-4d8e-a671-67eb165a6b1d'];

        $filter_as_array = [
            PhotoUuidFilter::ARRAY_KEY_PHOTO_UUID_LIST => $photo_uuid_list,
        ];

        $filter = PhotoUuidFilter::fromArray($filter_as_array);

        $this->assertEquals($filter->getPhotoUuidList(), $photo_uuid_list);
    }

    public function testFromArrayClassOverride()
    {
        $photo_uuid_list = ['a24e57e0-a1e9-4d8e-a671-67eb165a6b1d', 'b24e57e0-a1e9-4d8e-a671-67eb165a6b1d', 'c24e57e0-a1e9-4d8e-a671-67eb165a6b1d'];

        $filter_as_array = [
            PhotoUuidFilter::ARRAY_KEY_PHOTO_UUID_LIST => $photo_uuid_list,
        ];

        $filter = PhotoUuidFilter::fromArray($filter_as_array, MockPhotoUuidFilter::class);

        $this->assertEquals($filter->getPhotoUuidList(), $photo_uuid_list);

        $this->assertEquals('success4', $filter->action());
    }
}

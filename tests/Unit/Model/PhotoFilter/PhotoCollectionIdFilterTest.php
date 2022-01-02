<?php

namespace PhotoCentralStorage\Tests\Unit\Model\PhotoFilter;

use PhotoCentralStorage\Model\PhotoFilter\AddedTimestampRangeFilter;
use PhotoCentralStorage\Model\PhotoFilter\PhotoCollectionIdFilter;
use PHPUnit\Framework\TestCase;

class PhotoCollectionIdFilterTest extends TestCase
{
    public function testToArray()
    {
        $photo_collection_id_list = ['a', 'b', 'abc'];

        $filter = new PhotoCollectionIdFilter($photo_collection_id_list);
        $filter_as_array = $filter->toArray();

        $this->assertEquals($filter->getPhotoCollectionIdList(), $filter_as_array[PhotoCollectionIdFilter::ARRAY_KEY_PHOTO_COLLECTION_ID_LIST]);
    }

    public function testFromArray()
    {
        $photo_collection_id_list = ['a', 'b', 'abc'];

        $filter_as_array = [
            PhotoCollectionIdFilter::ARRAY_KEY_PHOTO_COLLECTION_ID_LIST => $photo_collection_id_list,
        ];

        $filter = PhotoCollectionIdFilter::fromArray($filter_as_array);

        $this->assertEquals($filter->getPhotoCollectionIdList(), $photo_collection_id_list);
    }

    public function testFromArrayClassOverride()
    {
        $photo_collection_id_list = ['a', 'b', 'abc'];

        $filter_as_array = [
            PhotoCollectionIdFilter::ARRAY_KEY_PHOTO_COLLECTION_ID_LIST => $photo_collection_id_list,
        ];

        $filter = PhotoCollectionIdFilter::fromArray($filter_as_array, MockPhotoCollectionIdFilter::class);

        $this->assertEquals($filter->getPhotoCollectionIdList(), $photo_collection_id_list);

        $this->assertEquals('success3', $filter->action());
    }
}

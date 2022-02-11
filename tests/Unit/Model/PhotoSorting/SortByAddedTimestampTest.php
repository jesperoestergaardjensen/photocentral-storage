<?php

namespace PhotoCentralStorage\Tests\Unit\Model\PhotoSorting;

use PhotoCentralStorage\Model\PhotoSorting\BasicSorting;
use PhotoCentralStorage\Model\PhotoSorting\SortByAddedTimestamp;
use PhotoCentralStorage\Photo;
use PHPUnit\Framework\TestCase;

class SortByAddedTimestampTest extends TestCase
{
    public function testToArray()
    {
        $sorting_direction = BasicSorting::DESC;

        $sorting = new SortByAddedTimestamp($sorting_direction);
        $sorting_as_array = $sorting->toArray();

        $this->assertEquals($sorting->getDirection(), $sorting_as_array[BasicSorting::ARRAY_KEY_DIRECTION]);
    }

    public function testFromArray()
    {
        $sorting_direction = BasicSorting::DESC;

        $sorting_as_array = [
            BasicSorting::ARRAY_KEY_DIRECTION => $sorting_direction,
        ];

        $sorting = SortByAddedTimestamp::fromArray($sorting_as_array);

        $this->assertEquals($sorting->getDirection(), $sorting_direction);
    }

    public function testFromArrayClassOverride()
    {
        $sorting_direction = BasicSorting::DESC;

        $sorting_as_array = [
            BasicSorting::ARRAY_KEY_DIRECTION => $sorting_direction,
        ];

        $sorting = SortByAddedTimestamp::fromArray($sorting_as_array, MockSortByAddedTimestamp::class);

        $this->assertEquals($sorting->getDirection(), $sorting_direction);

        $this->assertEquals('success10', $sorting->action());
    }

    public function testSortMethod()
    {
        $sorting_parameter_asc = new SortByAddedTimestamp(BasicSorting::ASC);
        $sorting_parameter_desc = new SortByAddedTimestamp(BasicSorting::DESC);

        $photo_added_base_timstamp = time();
        $exif_timestamp = time();

        $unsorted_photo_list = [
            new Photo('uuid-2', 'photo_collection_id_1', 100, 150, 1, $photo_added_base_timstamp+20, $exif_timestamp, null, null, 'Canon', 'Ixsus'),
            new Photo('uuid-1', 'photo_collection_id_1', 100, 150, 1, $photo_added_base_timstamp+10, $exif_timestamp, null, null, 'Canon', 'Ixsus'),
            new Photo('uuid-3', 'photo_collection_id_1', 100, 150, 1, $photo_added_base_timstamp+30, $exif_timestamp, null, null, 'Canon', 'Ixsus'),
        ];

        $expected_photo_list_asc = [
            new Photo('uuid-1', 'photo_collection_id_1', 100, 150, 1, $photo_added_base_timstamp+10, $exif_timestamp, null, null, 'Canon', 'Ixsus'),
            new Photo('uuid-2', 'photo_collection_id_1', 100, 150, 1, $photo_added_base_timstamp+20, $exif_timestamp, null, null, 'Canon', 'Ixsus'),
            new Photo('uuid-3', 'photo_collection_id_1', 100, 150, 1, $photo_added_base_timstamp+30, $exif_timestamp, null, null, 'Canon', 'Ixsus'),
        ];

        $expected_photo_list_desc = [
            new Photo('uuid-3', 'photo_collection_id_1', 100, 150, 1, $photo_added_base_timstamp+30, $exif_timestamp, null, null, 'Canon', 'Ixsus'),
            new Photo('uuid-2', 'photo_collection_id_1', 100, 150, 1, $photo_added_base_timstamp+20, $exif_timestamp, null, null, 'Canon', 'Ixsus'),
            new Photo('uuid-1', 'photo_collection_id_1', 100, 150, 1, $photo_added_base_timstamp+10, $exif_timestamp, null, null, 'Canon', 'Ixsus'),
        ];

        $sorted_photo_list_asc = $sorting_parameter_asc->sort($unsorted_photo_list);
        $sorted_photo_list_desc = $sorting_parameter_desc->sort($unsorted_photo_list);

        $this->assertEquals($expected_photo_list_asc, $sorted_photo_list_asc);
        $this->assertEquals($expected_photo_list_desc, $sorted_photo_list_desc);
    }
}
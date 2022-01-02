<?php

namespace PhotoCentralStorage\Tests\Unit\Model\PhotoSorting;

use PhotoCentralStorage\Model\PhotoSorting\SortByAddedTimestamp;
use PHPUnit\Framework\TestCase;

class SortByAddedTimestampTest extends TestCase
{
    public function testToArray()
    {
        $sorting_direction = SortByAddedTimestamp::DESC;

        $sorting = new SortByAddedTimestamp($sorting_direction);
        $sorting_as_array = $sorting->toArray();

        $this->assertEquals($sorting->getDirection(), $sorting_as_array[SortByAddedTimestamp::ARRAY_KEY_DIRECTION]);
    }

    public function testFromArray()
    {
        $sorting_direction = SortByAddedTimestamp::DESC;

        $sorting_as_array = [
            SortByAddedTimestamp::ARRAY_KEY_DIRECTION => $sorting_direction,
        ];

        $sorting = SortByAddedTimestamp::fromArray($sorting_as_array);

        $this->assertEquals($sorting->getDirection(), $sorting_direction);
    }

    public function testFromArrayClassOverride()
    {
        $sorting_direction = SortByAddedTimestamp::DESC;

        $sorting_as_array = [
            SortByAddedTimestamp::ARRAY_KEY_DIRECTION => $sorting_direction,
        ];

        $sorting = SortByAddedTimestamp::fromArray($sorting_as_array, MockSortByAddedTimestamp::class);

        $this->assertEquals($sorting->getDirection(), $sorting_direction);

        $this->assertEquals('success10', $sorting->action());
    }
}
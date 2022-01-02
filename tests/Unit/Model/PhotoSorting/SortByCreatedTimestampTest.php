<?php

namespace PhotoCentralStorage\Tests\Unit\Model\PhotoSorting;

use PhotoCentralStorage\Model\PhotoSorting\SortByCreatedTimestamp;
use PHPUnit\Framework\TestCase;

class SortByCreatedTimestampTest extends TestCase
{
    public function testToArray()
    {
        $sorting_direction = SortByCreatedTimestamp::DESC;

        $sorting = new SortByCreatedTimestamp($sorting_direction);
        $sorting_as_array = $sorting->toArray();

        $this->assertEquals($sorting->getDirection(), $sorting_as_array[SortByCreatedTimestamp::ARRAY_KEY_DIRECTION]);
    }

    public function testFromArray()
    {
        $sorting_direction = SortByCreatedTimestamp::DESC;

        $sorting_as_array = [
            SortByCreatedTimestamp::ARRAY_KEY_DIRECTION => $sorting_direction,
        ];

        $sorting = SortByCreatedTimestamp::fromArray($sorting_as_array);

        $this->assertEquals($sorting->getDirection(), $sorting_direction);
    }

    public function testFromArrayClassOverride()
    {
        $sorting_direction = SortByCreatedTimestamp::DESC;

        $sorting_as_array = [
            SortByCreatedTimestamp::ARRAY_KEY_DIRECTION => $sorting_direction,
        ];

        $sorting = SortByCreatedTimestamp::fromArray($sorting_as_array, MockSortByCreatedTimestamp::class);

        $this->assertEquals($sorting->getDirection(), $sorting_direction);

        $this->assertEquals('success11', $sorting->action());
    }
}

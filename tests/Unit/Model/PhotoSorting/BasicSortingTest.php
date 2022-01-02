<?php

namespace PhotoCentralStorage\Tests\Unit\Model\PhotoSorting;

use PhotoCentralStorage\Exception\PhotoCentralStorageException;
use PhotoCentralStorage\Model\PhotoSorting\BasicSorting;
use PHPUnit\Framework\TestCase;

class BasicSortingTest extends TestCase
{
    public function testToArray()
    {
        $sorting_direction = BasicSorting::DESC;

        $sorting = new BasicSorting($sorting_direction);
        $sorting_as_array = $sorting->toArray();

        $this->assertEquals($sorting->getDirection(), $sorting_as_array[BasicSorting::ARRAY_KEY_DIRECTION]);
    }

    public function testFromArray()
    {
        $sorting_direction = BasicSorting::DESC;

        $sorting_as_array = [
            BasicSorting::ARRAY_KEY_DIRECTION => $sorting_direction,
        ];

        $sorting = BasicSorting::fromArray($sorting_as_array);

        $this->assertEquals($sorting->getDirection(), $sorting_direction);
    }

    public function testException()
    {
        $this->expectException(PhotoCentralStorageException::class);

        new BasicSorting('invalid value');
    }
}

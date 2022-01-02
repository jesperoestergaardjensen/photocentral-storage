<?php

namespace PhotoCentralStorage\Tests\Unit\Model\PhotoSorting;

use PhotoCentralStorage\Model\PhotoSorting\SortByAddedTimestamp;

class MockSortByAddedTimestamp extends SortByAddedTimestamp
{
    public function action()
    {
        // Perform som implementation specific work here !!!
        return 'success10';
    }
}
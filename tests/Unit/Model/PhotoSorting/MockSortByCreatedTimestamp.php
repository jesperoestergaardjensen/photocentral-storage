<?php

namespace PhotoCentralStorage\Tests\Unit\Model\PhotoSorting;

use PhotoCentralStorage\Model\PhotoSorting\SortByCreatedTimestamp;

class MockSortByCreatedTimestamp extends SortByCreatedTimestamp
{
    public function action()
    {
        // Perform som implementation specific work here !!!
        return 'success11';
    }
}
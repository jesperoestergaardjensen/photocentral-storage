<?php

namespace PhotoCentralStorage\Tests\Unit\Model\PhotoFilter;

use PhotoCentralStorage\Model\PhotoFilter\AddedTimestampRangeFilter;

class MockAddedTimestampRangeFilter extends AddedTimestampRangeFilter
{
    public function action()
    {
        // Perform som implementation specific work here !!!
        return 'success';
    }
}
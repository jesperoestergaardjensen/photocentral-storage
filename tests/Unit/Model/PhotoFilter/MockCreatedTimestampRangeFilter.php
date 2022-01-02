<?php

namespace PhotoCentralStorage\Tests\Unit\Model\PhotoFilter;

use PhotoCentralStorage\Model\PhotoFilter\AddedTimestampRangeFilter;

class MockCreatedTimestampRangeFilter extends AddedTimestampRangeFilter
{
    public function action()
    {
        // Perform som implementation specific work here !!!
        return 'success2';
    }
}
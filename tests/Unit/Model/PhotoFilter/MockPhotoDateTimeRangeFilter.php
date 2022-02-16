<?php

namespace PhotoCentralStorage\Tests\Unit\Model\PhotoFilter;

use PhotoCentralStorage\Model\PhotoFilter\PhotoDateTimeRangeFilter;

class MockPhotoDateTimeRangeFilter extends PhotoDateTimeRangeFilter
{
    public function action()
    {
        // Perform som implementation specific work here !!!
        return 'success';
    }
}
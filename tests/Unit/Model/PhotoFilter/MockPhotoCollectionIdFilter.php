<?php

namespace PhotoCentralStorage\Tests\Unit\Model\PhotoFilter;

use PhotoCentralStorage\Model\PhotoFilter\PhotoCollectionIdFilter;

class MockPhotoCollectionIdFilter extends PhotoCollectionIdFilter
{
    public function action()
    {
        // Perform som implementation specific work here !!!
        return 'success3';
    }
}
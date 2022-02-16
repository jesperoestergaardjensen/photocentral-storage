<?php

namespace PhotoCentralStorage\Tests\Unit\Model\PhotoFilter;

use PhotoCentralStorage\Model\PhotoFilter\PhotoDateTimeRangeFilter;
use PHPUnit\Framework\TestCase;

class PhotoDateTimeRangeFilterTest extends TestCase
{
    public function testToArray()
    {
        $start_time = time() - 2000;
        $end_time = time() - 1000;

        $filter = new PhotoDateTimeRangeFilter($start_time, $end_time);
        $filter_as_array = $filter->toArray();

        $this->assertEquals($filter->getStartTimestamp(), $filter_as_array[PhotoDateTimeRangeFilter::ARRAY_KEY_START_TIME_STAMP]);
        $this->assertEquals($filter->getEndTimestamp(), $filter_as_array[PhotoDateTimeRangeFilter::ARRAY_KEY_END_TIME_STAMP]);
    }

    public function testFromArray()
    {
        $start_time = time() - 2000;
        $end_time = time() - 1000;

        $filter_as_array = [
            PhotoDateTimeRangeFilter::ARRAY_KEY_START_TIME_STAMP => $start_time,
            PhotoDateTimeRangeFilter::ARRAY_KEY_END_TIME_STAMP => $end_time
        ];

        $filter = PhotoDateTimeRangeFilter::fromArray($filter_as_array);

        $this->assertEquals($filter->getStartTimestamp(), $start_time);
        $this->assertEquals($filter->getEndTimestamp(), $end_time);
    }

    public function testFromArrayClassOverride()
    {
        $start_time = time() - 2000;
        $end_time = time() - 1000;

        $filter_as_array = [
            PhotoDateTimeRangeFilter::ARRAY_KEY_START_TIME_STAMP => $start_time,
            PhotoDateTimeRangeFilter::ARRAY_KEY_END_TIME_STAMP => $end_time
        ];

        $filter = PhotoDateTimeRangeFilter::fromArray($filter_as_array, MockPhotoDateTimeRangeFilter::class);

        $this->assertEquals($start_time, $filter->getStartTimestamp());
        $this->assertEquals($end_time, $filter->getEndTimestamp());

        $this->assertEquals('success', $filter->action());
    }
}

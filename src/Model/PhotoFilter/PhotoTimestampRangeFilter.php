<?php

namespace PhotoCentralStorage;

class PhotoTimestampRangeFilter implements PhotoFilter
{
    private int $start_timestamp;
    private int $end_timestamp;

    public function __construct(int $start_timestamp, int $end_timestamp)
    {
        $this->start_timestamp = $start_timestamp;
        $this->end_timestamp = $end_timestamp;
    }

    public function getStartTimestamp(): int
    {
        return $this->start_timestamp;
    }

    public function getEndTimestamp(): int
    {
        return $this->end_timestamp;
    }
}
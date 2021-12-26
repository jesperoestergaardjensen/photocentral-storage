<?php

namespace PhotoCentralStorage\Model\PhotoFilter;

class AddedTimestampRangeFilter implements PhotoFilter
{
    public const ARRAY_KEY_START_TIME_STAMP = 'start_timestamp';
    public const ARRAY_KEY_END_TIME_STAMP = 'end_timestamp';

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

    public function toArray(): array
    {
        return [
            self::ARRAY_KEY_START_TIME_STAMP => $this->start_timestamp,
            self::ARRAY_KEY_END_TIME_STAMP => $this->end_timestamp,
        ];
    }

    public static function fromArray($array, $return_class_override = self::class): PhotoFilter {
        return new $return_class_override($array[self::ARRAY_KEY_START_TIME_STAMP], $array[self::ARRAY_KEY_END_TIME_STAMP]);
    }
}
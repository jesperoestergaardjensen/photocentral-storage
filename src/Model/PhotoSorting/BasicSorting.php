<?php

namespace PhotoCentralStorage\Model\PhotoSorting;

use PhotoCentralStorage\Exception\PhotoCentralStorageException;

abstract class BasicSorting implements PhotoSorting
{
    const ARRAY_KEY_DIRECTION = 'direction';

    public const ASC = 'asc';
    public const DESC = 'desc';
    private string $direction;

    /**
     * @throws PhotoCentralStorageException
     */
    public function __construct(string $direction)
    {
        if ($direction !== self::ASC && $direction !== self::DESC) {
            throw new PhotoCentralStorageException("Invalid sorting direction provided: $direction - only 'asc' and 'desc' are allowed values");
        }
        $this->direction = $direction;
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }

    public function toArray(): array
    {
        return [
            self::ARRAY_KEY_DIRECTION => $this->direction
        ];
    }

    public static function fromArray($array, $return_class_override = self::class): PhotoSorting
    {
        return new $return_class_override($array[self::ARRAY_KEY_DIRECTION]);
    }
}

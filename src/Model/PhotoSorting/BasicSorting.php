<?php

namespace PhotoCentralStorage\Model\PhotoSorting;

use PhotoCentralStorage\Exception\PhotoCentralStorageException;

class BasicSorting implements PhotoSorting
{
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
}
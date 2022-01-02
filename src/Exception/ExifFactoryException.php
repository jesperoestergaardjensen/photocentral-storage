<?php

namespace PhotoCentralStorage\Exception;

use Exception;

class ExifFactoryException extends Exception
{
    public const CANNOT_READ_EXIF_DATA_FROM_FILE = 1;
    public const NOT_VALID_FILE                  = 2;
    public const NOT_VALID_FILE_OR_PATH          = 3;
    public const NOT_VALID_IMAGE_SIZE            = 4;
    public const NOT_VALID_IMAGE_TYPE            = 5;
}
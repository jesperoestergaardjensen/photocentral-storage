<?php

namespace PhotoCentralStorage\Model\PhotoFilter;

class PhotoUuidFilter implements PhotoFilter
{
    public const ARRAY_KEY_PHOTO_UUID_LIST = 'photo_uuid_list';

    private array $photo_uuid_list;

    public function __construct(array $photo_uuid_list)
    {
        $this->photo_uuid_list = $photo_uuid_list;
    }

    public function getPhotoUuidList(): array
    {
        return $this->photo_uuid_list;
    }

    public function toArray(): array
    {
        return [
            self::ARRAY_KEY_PHOTO_UUID_LIST => $this->photo_uuid_list
        ];
    }

    public static function fromArray($array, $return_class_override = self::class): PhotoFilter
    {
        return new $return_class_override($array[self::ARRAY_KEY_PHOTO_UUID_LIST]);
    }
}


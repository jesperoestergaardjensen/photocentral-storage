<?php

namespace PhotoCentralStorage\Model\PhotoFilter;

class PhotoUuidFilter implements PhotoFilter
{
    private array $photo_uuid_list;

    public function __construct(array $photo_uuid_list)
    {
        $this->photo_uuid_list = $photo_uuid_list;
    }

    public function getPhotoUuidList(): array
    {
        return $this->photo_uuid_list;
    }
}

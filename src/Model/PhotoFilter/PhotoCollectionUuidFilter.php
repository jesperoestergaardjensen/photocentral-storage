<?php

namespace PhotoCentralStorage;

class PhotoCollectionUuidFilter implements PhotoFilter
{
    private array $photo_collection_uuid_list;

    public function __construct(array $photo_uuid_list)
    {
        $this->photo_collection_uuid_list = $photo_uuid_list;
    }

    public function getPhotoUuidList(): array
    {
        return $this->photo_collection_uuid_list;
    }
}
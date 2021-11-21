<?php

namespace PhotoCentralStorage\Model\PhotoFilter;

class PhotoCollectionIdFilter implements PhotoFilter
{
    private array $photo_collection_id_list;

    public function __construct(array $photo_collection_id_list)
    {
        $this->photo_collection_id_list = $photo_collection_id_list;
    }

    public function getPhotoCollectionIdList(): array
    {
        return $this->photo_collection_id_list;
    }
}

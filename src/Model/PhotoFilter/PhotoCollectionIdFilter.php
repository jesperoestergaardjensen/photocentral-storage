<?php

namespace PhotoCentralStorage\Model\PhotoFilter;

class PhotoCollectionIdFilter implements PhotoFilter
{
    public const ARRAY_KEY_PHOTO_COLLECTION_ID_LIST = 'photo_collection_id_list';

    private array $photo_collection_id_list;

    public function __construct(array $photo_collection_id_list)
    {
        $this->photo_collection_id_list = $photo_collection_id_list;
    }

    public function getPhotoCollectionIdList(): array
    {
        return $this->photo_collection_id_list;
    }

    public function toArray(): array
    {
        return [
            self::ARRAY_KEY_PHOTO_COLLECTION_ID_LIST => $this->photo_collection_id_list
        ];
    }

    public static function fromArray($array, $return_class_override = self::class): PhotoFilter
    {
        return new $return_class_override($array[self::ARRAY_KEY_PHOTO_COLLECTION_ID_LIST]);
    }
}

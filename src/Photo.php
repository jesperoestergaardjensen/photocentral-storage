<?php

namespace PhotoCentralStorage;

use JsonSerializable;

final class Photo implements JsonSerializable
{
    private const PHOTO_UUID            = 'photo_uuid';
    private const WIDTH                 = 'width';
    private const HEIGHT                = 'height';
    private const ORIENTATION           = 'orientation';
    private const EXIF_DATE_TIME        = 'exif_date_time';
    private const FILE_SYSTEM_DATE_TIME = 'file_system_date_time';
    private const OVERRIDE_DATE_TIME    = 'override_date_time';
    private const CAMERA_BRAND          = 'camera_brand';
    private const CAMERA_MODEL          = 'camera_model';
    private const PHOTO_ADDED_DATE_TIME = 'row_added_date_time';
    private const STORAGE_TYPE          = 'storage_type';
    private const PHOTO_SOURCE_UUID     = 'photo_source_uuid';

    private string $photo_uuid;
    private int $width;
    private int $height;
    private int $orientation;
    private string $photo_collection_uuid;

    private int $photo_added_date_time;
    private int $fallback_date_time;

    private ?int $exif_date_time;
    private ?string $camera_brand;
    private ?string $camera_model;

    public function __construct(
        string $photo_uuid,
        string $photo_collection_uuid,
        int $width,
        int $height,
        int $orientation,
        int $photo_added_date_time,
        int $fallback_date_time,
        ?string $camera_model,
        ?string $camera_brand,
        ?int $exif_date_time
    ) {
        $this->photo_uuid = $photo_uuid;
        $this->photo_collection_uuid = $photo_collection_uuid;
        $this->width = $width;
        $this->height = $height;
        $this->orientation = $orientation;
        $this->photo_added_date_time = $photo_added_date_time;
        $this->fallback_date_time = $fallback_date_time;
        $this->camera_model = $camera_model;
        $this->camera_brand = $camera_brand;
        $this->exif_date_time = $exif_date_time;
    }

    public function getPhotoUuid(): string
    {
        return $this->photo_uuid;
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function getOrientation(): int
    {
        return $this->orientation;
    }

    public function getPhotoCollectionUuid(): string
    {
        return $this->photo_collection_uuid;
    }

    public function getPhotoAddedDateTime(): int
    {
        return $this->photo_added_date_time;
    }

    public function getFallbackDateTime(): int
    {
        return $this->fallback_date_time;
    }

    public function getExifDateTime(): ?int
    {
        return $this->exif_date_time;
    }

    public function getCameraBrand(): ?string
    {
        return $this->camera_brand;
    }

    public function getCameraModel(): ?string
    {
        return $this->camera_model;
    }

    public function jsonSerialize()
    {
        return $this->toArray();
    }

    public function toArray(): array
    {
        return [
            self::PHOTO_UUID            => $this->photo_uuid,
            self::WIDTH                 => $this->width,
            self::HEIGHT                => $this->height,
            self::ORIENTATION           => $this->orientation,
            self::STORAGE_TYPE          => SimpleLinuxStorage::class,
            self::PHOTO_SOURCE_UUID     => SimpleLinuxStorage::PHOTO_COLLECTION_UUID,
            self::PHOTO_ADDED_DATE_TIME   => $this->photo_added_date_time,
            self::CAMERA_BRAND          => $this->camera_brand,
            self::CAMERA_MODEL          => $this->camera_model,
            self::EXIF_DATE_TIME        => $this->exif_date_time,
            self::FILE_SYSTEM_DATE_TIME => $this->fallback_date_time,
            self::OVERRIDE_DATE_TIME    => null,
        ];
    }
}

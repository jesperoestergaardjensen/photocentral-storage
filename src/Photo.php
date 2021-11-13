<?php

namespace PhotoCentralStorage;

final class Photo
{
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
}

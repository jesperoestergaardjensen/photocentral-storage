<?php

class ExifData
{
    private int $width;
    private int $height;
    private int $orientation;
    private ?int $exif_date_time;
    private ?string $camera_brand;
    private ?string $camera_model;
    private ?float $latitude;
    private ?float $longitude;

    public function __construct(
        int $width,
        int $height,
        int $orientation,
        ?int $exif_date_time,
        ?string $camera_brand,
        ?string $camera_model,
        ?float $latitude,
        ?float $longitude
    ) {
        $this->width = $width;
        $this->height = $height;
        $this->orientation = $orientation;
        $this->exif_date_time = $exif_date_time;
        $this->camera_brand = $camera_brand;
        $this->camera_model = $camera_model;
        $this->latitude = $latitude;
        $this->longitude = $longitude;
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

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }
}

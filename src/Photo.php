<?php

namespace PhotoCentralStorage;

final class Photo
{
    private string $photo_uuid;
    private int $width;
    private int $height;
    private int $orientation;
    private ?int $exif_date_time;
    private ?int $file_system_date_time;
    private ?int $override_date_time;
    private ?string $camera_brand;
    private ?string $camera_model;
    private int $row_added_date_time;
    private string $photo_storage_uuid;
    private string $photo_collection_uuid;
}

<?php

namespace PhotoCentralStorage;

use JsonSerializable;
use PhotoCentralStorage\Exception\PhotoCentralStorageException;

final class Photo implements JsonSerializable
{
    public const  PHOTO_UUID            = 'photo_uuid';
    public const  PHOTO_COLLECTION_ID   = 'photo_collection_id';
    private const WIDTH                 = 'width';
    private const HEIGHT                = 'height';
    private const ORIENTATION           = 'orientation';
    private const PHOTO_ADDED_DATE_TIME = 'photo_added_date_time';
    private const EXIF_DATE_TIME        = 'exif_date_time';
    private const FILE_SYSTEM_DATE_TIME = 'file_system_date_time';
    private const OVERRIDE_DATE_TIME    = 'override_date_time';
    private const PHOTO_DATE_TIME       = 'photo_date_time';
    private const CAMERA_BRAND          = 'camera_brand';
    private const CAMERA_MODEL          = 'camera_model';
    public const  PHOTO_URL             = 'photo_url';

    private string $photo_uuid;
    private string $photo_collection_id;
    private int $width;
    private int $height;
    private int $orientation;
    private int $photo_added_date_time;
    private ?int $exif_date_time;
    private ?int $file_system_date_time;
    private ?int $override_date_time;
    private int $photo_date_time;
    private ?string $camera_brand;
    private ?string $camera_model;
    private string $photo_url = 'N/A';

    public function __construct(
        string $photo_uuid,
        string $photo_collection_id,
        int $width,
        int $height,
        int $orientation,
        int $photo_added_date_time,
        ?int $exif_date_time,
        ?int $file_system_date_time,
        ?int $override_date_time,
        ?string $camera_brand,
        ?string $camera_model
    ) {
        $this->photo_uuid = $photo_uuid;
        $this->photo_collection_id = $photo_collection_id;
        $this->width = $width;
        $this->height = $height;
        $this->orientation = $orientation;
        $this->photo_added_date_time = $photo_added_date_time;
        $this->exif_date_time = $exif_date_time;
        $this->file_system_date_time = $file_system_date_time;
        $this->override_date_time = $override_date_time;
        $this->camera_brand = $camera_brand;
        $this->camera_model = $camera_model;

        if ($exif_date_time === null && $file_system_date_time === null && $override_date_time === null) {
            throw new PhotoCentralStorageException('Photo object creation need at least one of exif_data_time/file_system_date_time/override_date_time to be set to a value');
        } else {
            $this->photo_date_time = $this->override_date_time ?? $this->exif_date_time ?? $this->file_system_date_time;
        }
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

    public function getPhotoCollectionId(): string
    {
        return $this->photo_collection_id;
    }

    public function getPhotoAddedDateTime(): int
    {
        return $this->photo_added_date_time;
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

    /**
     * @deprecated
     */
    public function getPhotoUrl(): string
    {
        return $this->photo_url;
    }

    /**
     * @deprecated
     */
    public function setPhotoUrl(string $photo_url): void
    {
        $this->photo_url = $photo_url;
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
            self::PHOTO_COLLECTION_ID   => $this->photo_collection_id,
            self::PHOTO_ADDED_DATE_TIME => $this->photo_added_date_time,
            self::EXIF_DATE_TIME        => $this->exif_date_time,
            self::FILE_SYSTEM_DATE_TIME => $this->file_system_date_time,
            self::OVERRIDE_DATE_TIME    => $this->override_date_time,
            self::PHOTO_DATE_TIME       => $this->photo_date_time,
            self::CAMERA_BRAND          => $this->camera_brand,
            self::CAMERA_MODEL          => $this->camera_model,
            self::PHOTO_URL             => $this->photo_url ?? 'N/A',
        ];
    }

    public static function fromArray($array): self
    {
        $self = new self(
            $array[self::PHOTO_UUID],
            $array[self::PHOTO_COLLECTION_ID],
            $array[self::WIDTH],
            $array[self::HEIGHT],
            $array[self::ORIENTATION],
            $array[self::PHOTO_ADDED_DATE_TIME],
            $array[self::EXIF_DATE_TIME],
            $array[self::FILE_SYSTEM_DATE_TIME],
            $array[self::OVERRIDE_DATE_TIME],
            $array[self::CAMERA_BRAND],
            $array[self::CAMERA_MODEL]
        );

        $self->setPhotoUrl($array[self::PHOTO_URL]);

        return $self;
    }

    /**
     * @return int
     */
    public function getPhotoDateTime(): int
    {
        return $this->photo_date_time;
    }

    /**
     * @param int|null $override_date_time
     */
    public function setOverrideDateTime(?int $override_date_time): void
    {
        if ($this->exif_date_time === null && $this->file_system_date_time === null && $override_date_time === null) {
            throw new PhotoCentralStorageException('At least one of exif_data_time/file_system_date_time/override_date_time has to be set to a value');
        } else {
            $this->override_date_time = $override_date_time;
            $this->photo_date_time = $this->override_date_time ?? $this->exif_date_time ?? $this->file_system_date_time;
        }
    }

    /**
     * @return int|null
     */
    public function getFileSystemDateTime(): ?int
    {
        return $this->file_system_date_time;
    }

    /**
     * @return int|null
     */
    public function getOverrideDateTime(): ?int
    {
        return $this->override_date_time;
    }

    public function setOrientation(int $orientation): void
    {
        $this->orientation = $orientation;
    }
}

<?php

namespace PhotoCentralStorage\Model;

use PhotoCentralStorage\Exception\PhotoCentralStorageException;

// TODO : QA - rename to PhotoDimensions
class ImageDimensions
{
    // thumb
    const THUMB_ID = 'thumb';
    // sd
    const SD_ID = 'sd';
    // hd
    const HD_ID = 'hd';
    // fhd
    const FHD_ID = 'fhd';

    private const VALID_ID_LIST = [
        self::THUMB_ID => ['id' => self::THUMB_ID, 'width' => 200, 'height' => 150],
        self::SD_ID    => ['id' => self::SD_ID, 'width' => 720, 'height' => 534],
        self::HD_ID    => ['id' => self::HD_ID, 'width' => 1280, 'height' => 720],
        self::FHD_ID   => ['id' => self::FHD_ID, 'width' => 1920, 'height' => 1080],
    ];

    private string $id;
    private int $width;
    private int $height;

    public function __construct(string $id, int $width, int $height)
    {
        $this->id = $id;
        $this->width = $width;
        $this->height = $height;
    }

    /**
     * @return int
     */
    public function getHeight(): int
    {
        return $this->height;
    }

    /**
     * @return int
     */
    public function getWidth(): int
    {
        return $this->width;
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    public function toArray(): array
    {
        return [
            'id'     => $this->id,
            'width'  => $this->width,
            'height' => $this->height,
        ];
    }

    public static function fromArray($array): self
    {
        return new self($array['id'], $array['width'], $array['height']);
    }

    /**
     * @throws PhotoCentralStorageException
     */
    public static function createFromId(string $id): self
    {
        if (! array_key_exists($id, self::VALID_ID_LIST)) {
            throw new PhotoCentralStorageException("ImageDimesions id {$id} is not valid");
        }

        return new self(self::VALID_ID_LIST[$id]['id'], self::VALID_ID_LIST[$id]['width'],
            self::VALID_ID_LIST[$id]['height']);
    }
}

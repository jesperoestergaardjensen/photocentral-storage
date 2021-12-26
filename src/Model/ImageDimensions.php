<?php

namespace PhotoCentralStorage\Model;

class ImageDimensions
{
    // EXAMPLE DIMENSIONS

    // thumb
    const THUMB_ID     = 'thumb';
    const THUMB_WIDTH  = 200;
    const THUMB_HEIGHT = 150;

    // sd
    const SD_ID     = 'sd';
    const SD_WIDTH  = 720;
    const SD_HEIGHT = 534;

    // hd
    const HD_ID     = 'hd';
    const HD_WIDTH  = 1280;
    const HD_HEIGHT = 720;

    // fhd
    const FHD_ID     = 'fhd';
    const FHD_WIDTH  = 1920;
    const FHD_HEIGHT = 1080;

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

    /**
     * @return ImageDimensions
     */
    public static function createThumb(): self
    {
        return new self(self::THUMB_ID, self::THUMB_WIDTH, self::THUMB_HEIGHT);
    }

    /**
     * @return ImageDimensions
     */
    public static function createSd(): self
    {
        return new self(self::SD_ID, self::SD_WIDTH, self::SD_HEIGHT);
    }

    /**
     * @return ImageDimensions
     */
    public static function createFhd(): self
    {
        return new self(self::FHD_ID, self::FHD_WIDTH, self::FHD_HEIGHT);
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
}

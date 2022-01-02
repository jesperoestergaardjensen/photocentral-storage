<?php

namespace PhotoCentralStorage\Tests\Unit\Model;

use PhotoCentralStorage\Exception\PhotoCentralStorageException;
use PhotoCentralStorage\Model\ImageDimensions;
use PHPUnit\Framework\TestCase;

class ImageDimensionsTest extends TestCase
{
    public function testConstructorAndGetMethods()
    {
        $id = 'custom_size';
        $width = 1112;
        $height = 465;

        $image_dimension = new ImageDimensions($id, $width, $height);

        $this->assertEquals($id, $image_dimension->getId(), 'id can be constructed and read correct');
        $this->assertEquals($width, $image_dimension->getWidth(), 'width can be constructed and read correct');
        $this->assertEquals($height, $image_dimension->getHeight(), 'height can be constructed and read correct');
    }

    public function testFromArrayAndToArray()
    {
        $image_dimensions_array = [
            'id'     => ImageDimensions::THUMB_ID,
            'width'  => 200,
            'height' => 150,
        ];

        $this->assertEquals($image_dimensions_array, ImageDimensions::fromArray($image_dimensions_array)->toArray(),
            'from and to array works correctly');
    }

    public function testCreateFromIdMethod()
    {
        // Test thumb dimension creation
        $image_dimesion_thumb = ImageDimensions::createFromId(ImageDimensions::THUMB_ID);
        $this->assertEquals('thumb', $image_dimesion_thumb->getId(), 'id is created correct');
        $this->assertEquals(200, $image_dimesion_thumb->getWidth(), 'width is created correct');
        $this->assertEquals(150, $image_dimesion_thumb->getHeight(), 'height is created correct');

        // Test sd dimension creation
        $image_dimesion_thumb = ImageDimensions::createFromId(ImageDimensions::SD_ID);
        $this->assertEquals('sd', $image_dimesion_thumb->getId(), 'id is created correct');
        $this->assertEquals(720, $image_dimesion_thumb->getWidth(), 'width is created correct');
        $this->assertEquals(534, $image_dimesion_thumb->getHeight(), 'height is created correct');

        // Test hd dimension creation
        $image_dimesion_thumb = ImageDimensions::createFromId(ImageDimensions::HD_ID);
        $this->assertEquals('hd', $image_dimesion_thumb->getId(), 'id is created correct');
        $this->assertEquals(1280, $image_dimesion_thumb->getWidth(), 'width is created correct');
        $this->assertEquals(720, $image_dimesion_thumb->getHeight(), 'height is created correct');

        // Test fhd dimension creation
        $image_dimesion_thumb = ImageDimensions::createFromId(ImageDimensions::FHD_ID);
        $this->assertEquals('fhd', $image_dimesion_thumb->getId(), 'id is created correct');
        $this->assertEquals(1920, $image_dimesion_thumb->getWidth(), 'width is created correct');
        $this->assertEquals(1080, $image_dimesion_thumb->getHeight(), 'height is created correct');

        // Test exception
        $this->expectException(PhotoCentralStorageException::class);
        ImageDimensions::createFromId('non existing id');
    }
}

<?php

namespace PhotoCentralStorage\Tests\Unit\Model;

use PhotoCentralStorage\Model\ExifData;
use PHPUnit\Framework\TestCase;

class ExifDataTest extends TestCase
{
    private int $width = 100;
    private int $height = 150;
    private int $orientation = 1;
    private int $exit_date_time = 1641078581;
    private string $camera_brand = 'Canon';
    private string $camera_model = 'Powershot';
    private float $latitude = 2.12345;
    private float $longitude = 11.12345;

    public function testConstructorAndGetMethods()
    {
        $exif_data = new ExifData($this->width, $this->height, $this->orientation, $this->exit_date_time, $this->camera_brand, $this->camera_model, $this->latitude, $this->longitude);

        $this->assertEquals($exif_data->getWidth(), $this->width, 'correct width value is set and read');
        $this->assertEquals($exif_data->getHeight(), $this->height, 'correct height value is set and read');
        $this->assertEquals($exif_data->getOrientation(), $this->orientation, 'correct orientation value is set and read');
        $this->assertEquals($exif_data->getExifDateTime(), $this->exit_date_time, 'correct exif date time value is set and read');
        $this->assertEquals($exif_data->getCameraBrand(), $this->camera_brand, 'correct camera brand value is set and read');
        $this->assertEquals($exif_data->getCameraModel(), $this->camera_model, 'correct camera brand value is set and read');
        $this->assertEquals($exif_data->getLatitude(), $this->latitude, 'correct latitude value is set and read');
        $this->assertEquals($exif_data->getLongitude(), $this->longitude, 'correct langitude value is set and read');
    }
}
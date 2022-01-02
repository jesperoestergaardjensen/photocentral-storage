<?php

namespace PhotoCentralStorage\Tests\Unit\Factory;

use PhotoCentralStorage\Exception\ExifFactoryException;
use PhotoCentralStorage\Factory\ExifDataFactory;
use PhotoCentralStorage\Model\ExifData;
use PHPUnit\Framework\TestCase;

class ExifFactoryTest extends TestCase
{
    public function testCreateExifDataMethod()
    {
        $test_file = dirname(__FILE__, 3) . '/data/coffee-break.jpg';

        $exif_data = ExifDataFactory::createExifData($test_file);

        $this->assertInstanceOf(ExifData::class, $exif_data, 'object created should be of type ExifData');

        $this->assertEquals(386, $exif_data->getHeight(), 'correct height should be found');
        $this->assertEquals(686, $exif_data->getWidth(), 'correct width should be found');
        $this->assertEquals(1636465831, $exif_data->getExifDateTime(), 'correct exif date time should be found');
        $this->assertEquals('ASUS', $exif_data->getCameraBrand(), 'correct camera brand should be found');
        $this->assertEquals('ASUS_I002D', $exif_data->getCameraModel(), 'correct camera model should be found');
        $this->assertEquals(6, $exif_data->getOrientation(), 'correct orentation should be found');
        $this->assertEquals(10.419136111111111, $exif_data->getLongitude(), 'correct longitude should be found');
        $this->assertEquals(55.39681111111111, $exif_data->getLatitude(), 'correct latitude should be found');
    }

    public function testExceptionNotAFile()
    {
        $test_file = dirname(__FILE__, 3) . '/data/';

        $this->expectException(ExifFactoryException::class);
        $this->expectExceptionCode(ExifFactoryException::NOT_VALID_FILE);

        $exif_data = ExifDataFactory::createExifData($test_file);
    }

    public function testExceptionsInvalidFile()
    {
        $test_file = dirname(__FILE__, 3) . '/data$%¥coffee-break';

        $this->expectException(ExifFactoryException::class);
        $this->expectExceptionCode(ExifFactoryException::NOT_VALID_FILE_OR_PATH);

        $exif_data = ExifDataFactory::createExifData($test_file);
    }

    public function testExceptionsInvalidImageSize()
    {
        $test_file = dirname(__FILE__, 3) . '/data/faultyh-file.jpg';

        $this->expectException(ExifFactoryException::class);
        $this->expectExceptionCode(ExifFactoryException::NOT_VALID_IMAGE_SIZE);

        $exif_data = ExifDataFactory::createExifData($test_file);
    }

    public function testExceptionsInvalidImageType()
    {
        $test_file = dirname(__FILE__, 3) . '/data/not-an-image.txt';

        $this->expectException(ExifFactoryException::class);
        $this->expectExceptionCode(ExifFactoryException::NOT_VALID_IMAGE_TYPE);

        $exif_data = ExifDataFactory::createExifData($test_file);
    }

    public function testExceptionsNoExifData()
    {
        $test_file = dirname(__FILE__, 3) . '/data/not-jpg.png';

        $this->expectException(ExifFactoryException::class);
        $this->expectExceptionCode(ExifFactoryException::CANNOT_READ_EXIF_DATA_FROM_FILE);

        ExifDataFactory::createExifData($test_file);
    }

    public function testStrangeExifDate()
    {
        $test_file = dirname(__FILE__, 3) . '/data/date-issue.jpg';
/*        $this->expectException(ExifFactoryException::class);
        $this->expectExceptionCode(ExifFactoryException::NOT_VALID_FILE);*/
        $exif_data = ExifDataFactory::createExifData($test_file);
        $this->assertInstanceOf(ExifData::class, $exif_data);
    }

    public function testFaulthyFileExample1()
    {
        $test_file = dirname(__FILE__, 4) . '/vendor/jesperoestergaardjensen/exif-samples/jpg/invalid/image00971.jpg';
/*        $this->expectException(ExifFactoryException::class);
        $this->expectExceptionCode(ExifFactoryException::NOT_VALID_FILE);*/
        $exif_data = ExifDataFactory::createExifData($test_file);
        $this->assertInstanceOf(ExifData::class, $exif_data);
    }

    public function testFaulthyFileExample2()
    {
        $test_file = dirname(__FILE__, 4) . '/vendor/jesperoestergaardjensen/exif-samples/jpg/invalid/image01088.jpg';
/*        $this->expectException(ExifFactoryException::class);
        $this->expectExceptionCode(ExifFactoryException::NOT_VALID_FILE);*/
        $exif_data = ExifDataFactory::createExifData($test_file);
        $this->assertInstanceOf(ExifData::class, $exif_data);
    }

    public function testFaulthyFileExample3()
    {
        $test_file = dirname(__FILE__, 4) . '/vendor/jesperoestergaardjensen/exif-samples/jpg/invalid/image01137.jpg';
/*        $this->expectException(ExifFactoryException::class);
        $this->expectExceptionCode(ExifFactoryException::NOT_VALID_FILE);*/
        $exif_data = ExifDataFactory::createExifData($test_file);
        $this->assertInstanceOf(ExifData::class, $exif_data);
    }

    public function testFaulthyFileExample4()
    {
        $test_file = dirname(__FILE__, 4) . '/vendor/jesperoestergaardjensen/exif-samples/jpg/invalid/image01551.jpg';
/*        $this->expectException(ExifFactoryException::class);
        $this->expectExceptionCode(ExifFactoryException::NOT_VALID_FILE);*/
        $exif_data = ExifDataFactory::createExifData($test_file);
        $this->assertInstanceOf(ExifData::class, $exif_data);
    }

    public function testFaulthyFileExample5()
    {
        $test_file = dirname(__FILE__, 4) . '/vendor/jesperoestergaardjensen/exif-samples/jpg/invalid/image01713.jpg';
/*        $this->expectException(ExifFactoryException::class);
        $this->expectExceptionCode(ExifFactoryException::NOT_VALID_FILE);*/
        $exif_data = ExifDataFactory::createExifData($test_file);
        $this->assertInstanceOf(ExifData::class, $exif_data);
    }

    public function testFaulthyFileExample6()
    {
        $test_file = dirname(__FILE__, 4) . '/vendor/jesperoestergaardjensen/exif-samples/jpg/invalid/image01980.jpg';
/*        $this->expectException(ExifFactoryException::class);
        $this->expectExceptionCode(ExifFactoryException::NOT_VALID_FILE);*/
        $exif_data = ExifDataFactory::createExifData($test_file);
        $this->assertInstanceOf(ExifData::class, $exif_data);
    }

    public function testFaulthyFileExample7()
    {
        $test_file = dirname(__FILE__, 4) . '/vendor/jesperoestergaardjensen/exif-samples/jpg/invalid/image02206.jpg';
/*        $this->expectException(ExifFactoryException::class);
        $this->expectExceptionCode(ExifFactoryException::NOT_VALID_FILE);*/
        $exif_data = ExifDataFactory::createExifData($test_file);
        $this->assertInstanceOf(ExifData::class, $exif_data);
    }
}

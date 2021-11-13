<?php

namespace PhotoCentralStorage\Factory;

use PhotoCentralStorage\Exception\PhotoCentralStorageException;
use PhotoCentralStorage\Model\ExifData;

class ExifDataFactory
{
    /**
     * @param string $full_image_file_name_and_path
     *
     * @return ExifData
     * @throws PhotoCentralStorageException
     */
    public static function createExifData(string $full_image_file_name_and_path) : ExifData {
        if (is_file($full_image_file_name_and_path) === false) {
            throw new PhotoCentralStorageException("$full_image_file_name_and_path is not a valid file");
        }

        // By trial and error, it seems that a file has to be 12 bytes or larger in order to avoid a "Read error!".  Here's a work-around to avoid an error being thrown:
        // exif_imagetype throws "Read error!" if file is too small
        if (filesize($full_image_file_name_and_path) < 12) {
            throw new PhotoCentralStorageException("$full_image_file_name_and_path is not a valid image");
        }

        if (exif_imagetype($full_image_file_name_and_path) === false) {
            throw new PhotoCentralStorageException("$full_image_file_name_and_path is not a valid image");
        }

        if (!is_file($full_image_file_name_and_path)) {
            throw new PhotoCentralStorageException($full_image_file_name_and_path . " - is not a valid file!");
        } else if (!file_exists($full_image_file_name_and_path)) {
            throw new PhotoCentralStorageException($full_image_file_name_and_path . " - is not a valid path");
        } else {

            // Get a lot of photo information
            @$exif = exif_read_data($full_image_file_name_and_path);

            if ($exif === false) {
                throw new PhotoCentralStorageException("Cannot read exif data from file: $full_image_file_name_and_path");
            }

            // Not all photos seem to have the Orientation info ?!?! - Handle this
            array_key_exists('Orientation', $exif) ? $orientation = $exif['Orientation'] : $orientation = 0;

            // Set date photo was taken
            if (!isset($exif['DateTimeOriginal']) || $exif['DateTimeOriginal'] == null) {
                if (!isset($exif['DateTimeDigitized']) || $exif['DateTimeDigitized'] == null) {
                    if (!isset($exif['FileDateTime']) || $exif['FileDateTime'] == null || $exif['FileDateTime'] < 0) {
                        $datePhotoTaken = null;
                    } else {
                        $datePhotoTaken = date("Y:m:d H:i:s", $exif['FileDateTime']);
                    }
                } else {
                    $datePhotoTaken = $exif['DateTimeDigitized'];
                }
            } else {
                $datePhotoTaken = $exif['DateTimeOriginal'];
            }

            if (isset($exif["GPSLatitude"]) && isset($exif['GPSLatitudeRef'])) {
                $latitude = self::getGps($exif["GPSLatitude"], $exif['GPSLatitudeRef']);
            } else {
                $latitude = null;
            }

            if ($latitude !== null && isset($exif["GPSLongitude"]) && isset($exif['GPSLongitudeRef'])) {
                $longitude = self::getGps($exif["GPSLongitude"], $exif['GPSLongitudeRef']);
            } else {
                $longitude = null;
            }

            return new ExifData(
                $exif['COMPUTED']['Width'],
                $exif['COMPUTED']['Height'],
                $orientation,
                strtotime($datePhotoTaken),
                $exif['Make'] ?? null,
                $exif['Model'] ?? null,
                $latitude,
                $longitude
            );
        }
    }

    private static function getGps($coordinate, $hemisphere): float {
        if (is_string($coordinate)) {
            $coordinate = array_map("trim", explode(",", $coordinate));
        }
        for ($i = 0; $i < 3; $i++) {
            $part = explode('/', $coordinate[$i]);
            if (count($part) == 1) {
                $coordinate[$i] = $part[0];
            } else if (count($part) == 2) {
                $coordinate[$i] = floatval($part[0])/floatval($part[1]);
            } else {
                $coordinate[$i] = 0;
            }
        }
        [$degrees, $minutes, $seconds] = $coordinate;
        $sign = ($hemisphere == 'W' || $hemisphere == 'S') ? -1 : 1;
        return $sign * ($degrees + $minutes/60 + $seconds/3600);
    }
}

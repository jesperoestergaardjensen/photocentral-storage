<?php

namespace PhotoCentralStorage\Tests\Unit;

use PhotoCentralStorage\PhotoCentralStorage;

interface PhotoCentralStorageTest
{
    public function initializePhotoCentralStorage(): PhotoCentralStorage;
    public function setupExpectedProperties();
    public function testGetPhoto();
    public function testlistPhotoQuantityByYear();
    public function testlistPhotoQuantityByMonth();
    public function testlistPhotoQuantityByDay();
    public function testListPhotos();
    public function testGetPathOrUrlToPhoto();
    public function testGetPathOrUrlToCachedPhoto();
    public function testSoftDeleteExistingPhoto();
    public function testSoftDeleteNonExistingPhoto();
    public function testUndoSoftDeleteExistingPhoto();
    public function testUndoSoftDeleteNonExistingPhoto();
}
<?php

namespace PhotoCentralStorage\Tests\Unit\Model;

use PhotoCentralStorage\Photo;
use PhotoCentralStorage\PhotoCollection;
use PHPUnit\Framework\TestCase;

class PhotoCollectionTest extends TestCase
{
    public function testConstructorAndGetMethods()
    {
        $id = 'A1';
        $name = 'Test photo collection';
        $enabled = true;
        $description = 'Test photo collection description goes here';
        $last_updated = time();

        $photo_collection = new PhotoCollection($id, $name, $enabled, $description, $last_updated);

        $this->assertEquals($id, $photo_collection->getId(), 'correct id value is set and read');
        $this->assertEquals($name, $photo_collection->getName(), 'correct name value is set and read');
        $this->assertEquals($description, $photo_collection->getDescription(), 'correct description value is set and read');
        $this->assertEquals($enabled, $photo_collection->isEnabled(), 'correct enabled value is set and read');
        $this->assertEquals($last_updated, $photo_collection->getLastUpdated(), 'correct last updated value is set and read');
    }

    public function testFromArrayToArrayMethods()
    {
        $photo_collection_as_array = [
            'id' => 'A1',
            'name' => 'Test photo collection',
            'enabled' => true,
            'description' => 'Test photo collection description goes here',
            'last_updated' => time()
        ];

        $this->assertEquals($photo_collection_as_array, PhotoCollection::fromArray($photo_collection_as_array)->toArray(), 'fromArray and toArray work correct');
    }

    public function testSetMethod()
    {
        $id = 'A2';
        $name = 'Test photo collection 2';
        $enabled = false;
        $description = 'Test photo collection 2 description goes here';

        $photo_collection = new PhotoCollection($id, $name, $enabled, $description, null);

        $this->assertNull($photo_collection->getLastUpdated(), 'last updated is null initially');
        $last_updated = time();
        $photo_collection->setLastUpdated($last_updated);
        $this->assertEquals($last_updated, $photo_collection->getLastUpdated(), 'set last updated value can be updated correctly');
    }
}

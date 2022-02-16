<?php

namespace PhotoCentralStorage\Tests\Unit\Model\PhotoQuantity;

use PhotoCentralStorage\Model\PhotoQuantity\PhotoQuantityYear;
use PHPUnit\Framework\TestCase;

class PhotoQuantityYearTest extends TestCase
{
    public function testConstructorSettersAndGetters()
    {
        $expected_year_label = '12';
        $expected_year_value = 12;
        $expected_quantity = 10;
        $expected_updated_quantity = 100;

        $photo_quantity_year = new PhotoQuantityYear($expected_year_label, $expected_year_value, $expected_quantity);

        $this->assertEquals($expected_year_value, $photo_quantity_year->getYearValue());
        $this->assertEquals($expected_year_label, $photo_quantity_year->getYearLabel());
        $this->assertEquals($expected_quantity, $photo_quantity_year->getQuantity());

        $photo_quantity_year->setQuantity($expected_updated_quantity);
        $this->assertEquals($expected_updated_quantity, $photo_quantity_year->getQuantity());
    }

    public function testFromToArrayAndSerialize()
    {
        $expected_array = ['year_label' => '2000' , 'year_value' => 2000, 'quantity' => 10];

        $photo_quantity_year_from_array = PhotoQuantityYear::fromArray($expected_array);

        $this->assertEquals($expected_array, $photo_quantity_year_from_array->toArray());

        $result = json_encode($photo_quantity_year_from_array);

        $this->assertEquals(json_encode($expected_array), $result);
    }
}
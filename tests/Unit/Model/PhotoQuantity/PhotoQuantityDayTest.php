<?php

namespace PhotoCentralStorage\Tests\Unit\Model\PhotoQuantity;

use PhotoCentralStorage\Model\PhotoQuantity\PhotoQuantityDay;
use PHPUnit\Framework\TestCase;

class PhotoQuantityDayTest extends TestCase
{
    public function testConstructorSettersAndGetters()
    {
        $expected_day_label = '12';
        $expected_day_value = 12;
        $expected_quantity = 10;
        $expected_updated_quantity = 100;

        $photo_quantity_day = new PhotoQuantityDay($expected_day_label, $expected_day_value, $expected_quantity);

        $this->assertEquals($expected_day_value, $photo_quantity_day->getDayValue());
        $this->assertEquals($expected_day_label, $photo_quantity_day->getDayLabel());
        $this->assertEquals($expected_quantity, $photo_quantity_day->getQuantity());

        $photo_quantity_day->setQuantity($expected_updated_quantity);
        $this->assertEquals($expected_updated_quantity, $photo_quantity_day->getQuantity());
    }

    public function testFromToArrayAndSerialize()
    {
        $expected_array = ['day_label' => '12' , 'day_value' => 12, 'quantity' => 10];

        $photo_quantity_day_from_array = PhotoQuantityDay::fromArray($expected_array);

        $this->assertEquals($expected_array, $photo_quantity_day_from_array->toArray());

        $result = json_encode($photo_quantity_day_from_array);

        $this->assertEquals(json_encode($expected_array), $result);
    }
}
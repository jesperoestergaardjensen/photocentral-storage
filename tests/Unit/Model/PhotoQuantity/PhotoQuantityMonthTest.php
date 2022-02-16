<?php

namespace PhotoCentralStorage\Tests\Unit\Model\PhotoQuantity;

use PhotoCentralStorage\Model\PhotoQuantity\PhotoQuantityMonth;
use PHPUnit\Framework\TestCase;

class PhotoQuantityMonthTest extends TestCase
{
    public function testConstructorSettersAndGetters()
    {
        $expected_month_label = '12';
        $expected_month_value = 12;
        $expected_quantity = 10;
        $expected_updated_quantity = 100;

        $photo_quantity_month = new PhotoQuantityMonth($expected_month_label, $expected_month_value, $expected_quantity);

        $this->assertEquals($expected_month_value, $photo_quantity_month->getMonthValue());
        $this->assertEquals($expected_month_label, $photo_quantity_month->getMonthLabel());
        $this->assertEquals($expected_quantity, $photo_quantity_month->getQuantity());

        $photo_quantity_month->setQuantity($expected_updated_quantity);
        $this->assertEquals($expected_updated_quantity, $photo_quantity_month->getQuantity());
    }

    public function testFromToArrayAndSerialize()
    {
        $expected_array = ['month_label' => '12' , 'month_value' => 12, 'quantity' => 10];

        $photo_quantity_month_from_array = PhotoQuantityMonth::fromArray($expected_array);

        $this->assertEquals($expected_array, $photo_quantity_month_from_array->toArray());

        $result = json_encode($photo_quantity_month_from_array);

        $this->assertEquals(json_encode($expected_array), $result);
    }
}
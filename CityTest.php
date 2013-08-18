<?php
require('city.php');
class CityTest extends PHPUnit_Framework_TestCase
{
    private $city_id;
    private $city;

    public static function setUpBeforeClass(){
         $db = require('pdo.php');
         $db->exec("DELETE FROM CITIES");
         $db->exec("DELETE FROM AREAS");
         parent::setUp();
    }

    public function testInitCity(){
        $city = new City();
        $this->city = $city;
        $city_attr = $city->attributes();
        $this->assertTrue(is_array($city_attr));
        $this->city_id = $city_attr['id']; 
    }


    public function testQueryCity(){
        $city = new City($this->city_id);
        $this->assertTrue(is_array($city->attributes()));
        $city = new City(100000000000);
        $this->assertNull($city->attributes());
    }

    public function testCreateCity(){
        $city = new City();
        $new_city = $city->create_city(4,5);
        $this->assertTrue(is_array($new_city->attributes()));
        
        //create on an occiputed area
        $new_city = $city->create_city(4,5);
        $this->assertEquals($new_city, "this area is occupied");
    }

    public function testStatus(){
        $city = new City();
        $status = $city->status();
    }

    public function testChangeTax(){
        $city = new City();
        $city->change_tax(0.8);
        $attr = $city->attributes();
        $this->assertEquals(0.8, $attr['tax']);
    }

    public function testSetCapital(){
        $city = new City();
        $city->set_capital();
        
    }
    
}

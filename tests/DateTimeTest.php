<?php

require dirname(__FILE__).'/../load.php';

class DateTimeTest extends PHPUnit_Framework_TestCase {
    
    public function testDateTimeTransformBRforEUA() {
        $date = PWork\Util\DateTime::dateTimeTransformBRforEUA('09/04/1980 07:50:00');
        
        $this->assertEquals($date,'1980-04-09 07:50:00');
    }
    
    public function testDateTimeTransformEUAforBR() {
        $date = PWork\Util\DateTime::dateTimeTransformEUAforBR('1980-04-09 07:50:00');
        
        $this->assertEquals($date,'09/04/1980 07:50:00');
        
        $date = PWork\Util\DateTime::dateTimeTransformEUAforBR('1980-04-09','d/m/Y');
        
        $this->assertEquals($date,'09/04/1980');
    }
}

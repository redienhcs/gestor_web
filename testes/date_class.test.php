<?php

require_once('simpletest/autorun.php');
require_once('../lib/classes/DateClass.class.php');

class TestOfDateClass extends UnitTestCase {
    
    function testValidarData() {
        
        $log = new DateClass();
        $this->assertTrue( DateClass::isValid( '27/12/1988','%d/%m/%Y'));
        $this->assertTrue( DateClass::isValid( '27/12/1988'));
//        $this->assertTrue( DateClass::isValid( '27/12/1988','%d/%m/%Y'));
//        $this->assertTrue( DateClass::isValid( '27/12/1988','%d/%m/%Y'));
    }
    
}
?>

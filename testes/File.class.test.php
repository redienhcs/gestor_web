<?php
require_once('../simpletest/autorun.php');
require_once('File.class.php');

class FileHandlingTest extends UnitTestCase {
    
    function testCriacaoDeArquivo() {
        $filename = '/tmp/testFile.txt';
        
        $file = new File($filename);
        $file->open();
        $this->assertTrue(file_exists($filename));
        echo $file->getError();
        $file = null;
        $this->assertTrue(file_exists($filename));
        
        @unlink($filename);
        
        $file = new File($filename);
        $file->isTemp(true);
        $file->open();
        $this->assertTrue(file_exists($filename));
        echo $file->getError();
        $file = null;
        $this->assertFalse(file_exists($filename));
        
                
        
        
        
    }
    
    

}
?>

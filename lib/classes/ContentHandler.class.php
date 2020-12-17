<?php
/**
 * Description of ContentHandler
 *
 * @author anderson
 */
class ContentHandler {

    //put your code here
    private $safeList = array();
    public $moduleName = '';

    public function __construct() {
        
    }

    private function init() {
        
    }

    public function setModuleName( $moduleName) {
        $this->$moduleName = $moduleName;
    }

    public function getModuleName( ) {

        echo $this->moduleName;
        return $this->$moduleName;
    }

    public function loadSafeList($safeList) {
        $this->safeList = $safeList;
    }

    public function getContent($content) {
        

        if ( $this->moduleName != '') {
            $contentPath = 'modules/'.$this->moduleName.'/inc/' . $this->safeList[$content] . '.inc.php';
            
            return require_once $contentPath;

        } else {
            if (!empty($content) && is_string($content) && isset($this->safeList[$content]) && file_exists("inc/{$this->safeList[$content]}.inc.php")) {
                
                return require_once 'inc/' . $this->safeList[$content] . '.inc.php';
            }

        }
    }

}

<?php
class WebAdmin {

    private static $selfInstance = null;
    private $config = null;
    private $contentHandler = null;
    private $moduleName = null;

    public function __construct() {
        self::$selfInstance = $this;

        /*
          0 . TODO Carregar configuraçoes do modulo
         */
        //$this->loadConfig($_CFG);

        $this->init();
    }

    private function init() {
        
        $anhur = Anhur::getInstance();
        $this->moduleName = 'webadmin';

        //Carrega as configuraçoes do modulo
        $_CFG = $anhur->getModuleConf( $this->moduleName);

        $this->loadConfig( $_CFG['safe_list'][$this->moduleName]);

        //Carrega a classe
        $anhur->loadClass('ContentHandler');
        
        $this->contentHandler = new ContentHandler();
        $this->contentHandler->setModuleName( $this->moduleName);
        $this->contentHandler->loadSafeList($this->config);

        $objContentHandler = new ContentHandler();
        $objContentHandler->moduleName = $this->moduleName;
        $objContentHandler->loadSafeList($this->config);

        $this->contentHandler = $objContentHandler;
    }

    public function getContentHandler() {
        return $this->contentHandler;
    }

    public function getContents() {
        $objAnhur = Anhur::getInstance();
        /*
        if (!$this->verificarLoginUsuario()) {
            $objAnhur->setCurrentPage('autenticacao');
        } elseif ($objAnhur->getCurrentPage() == NULL) {
            $objAnhur->setCurrentPage('home');
        }
        */
        $objAnhur->setCurrentPage('home');
        
        return $this->getContentHandler()->getContent( $objAnhur->getCurrentPage());
    }

    public function setContentHandler($contentHandler) {
        $this->contentHandler = $contentHandler;
    }

    public static function getInstance() {
        return self::$selfInstance;
    }

    private function loadConfig($config) {
        $this->config = $config;
    }

    public function getConf($key) {
        return $this->config[$key];
    }

    public function SetConf($key, $value) {
        $this->config[$key] = $value;
    }

}

new WebAdmin();
?>


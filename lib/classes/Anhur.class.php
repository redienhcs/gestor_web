<?php

/* * *****************************************************************************
 * ÚLTIMA ATUALIZAÇÃO
 * ============
 * Outubro, 19 2019
 *
 *
 * AUTOR
 * =============
 * Anderson Felipe Schneider <hactar@universo.univates.br>
 * 
 * 
 * PROPÓSITO
 * =============
 * Provêr funções básicas para o funcionamento do sistema.
 *
 * 
  \******************************************************************************************************************** */

class Anhur {

    private static $selfInstance = null;
    private $dateclass;
    private $config;
    private $pagination;
    private $currentModule = null;
    private $currentPage = null;
    private $currentAction = null;
    private $contentHandler = null;

    public function __construct() {
        $this->init();

        self::$selfInstance = $this;
    }

    private function init() {

        $this->loadClass('dBug');
        //Obtém as informações do arquivo de configurações e carrega no sistema
        require_once 'etc/config.ini.php';
        
        $this->loadConfig($_CFG);
        
        
        //Set the content Handler
        require_once 'ContentHandler.class.php';
        $this->contentHandler = new ContentHandler();
        $this->contentHandler->loadSafeList($_CFG['safe_list']['modules']);
        
        
        //require_once 'DateClass.class.php';
        //$this->dateclass = new DateClass();
        
        require_once 'ExternalTools.class.php';
        //require_once 'Mysql.class.php';

        require_once 'Notificacoes.class.php';
        
        
    }
    
    public function getContents() {
        
        /*
         * 
        5. TODO Sanitificar variáveis no getContents do anhur
         */
        if ( $this->getCurrentModule() == null ) {
            $this->setCurrentModule( $this->getConf( 'default_module'));
        }
        
        return $this->getContentHandler()->getContent( $this->getCurrentModule());
        
    }
    
    public function getContentHandler() {
        return $this->contentHandler;
    }

    public function setContentHandler($contentHandler) {
        $this->contentHandler = $contentHandler;
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

    /*
      1 . TODO Transferir a funçao obterPaginacao para um arquivo separado
     */

    public function obterPaginacao($totalItens, $itensPorPagina = null) {
        require_once('Pagination.class.php');

        if ($itensPorPagina == null) {
            $itensPorPagina = $this->getConf('paginacao')['itens_pagina'];
        }

        if (!$this->pagination instanceof Pagination) {
            $this->pagination = new Pagination($totalItens, $itensPorPagina);
        }

        return $this->pagination;
    }

    public static function getInstance() {
        return self::$selfInstance;
    }



    /**
     * Faz um var_export (um tipo de var_dump) para o console do firebug.<br />
     * A função irá tratar os dados para evitar erros de javascript.<br />
     * Você pode passar o que quiser para um var_dump: object, array, string, ou outra coisa.<br />
     * Esta função aceita múltiplos parâmetros.
     *
     *  TODO Verificar se esta função ainda está em funcionamento
     * @param any $args
     */
    public static function clog($args) {
        $exTools = ExternalTools::getInstance();
        $result = Anhur::dataforFirebugConsole(func_get_args());
        if (is_array($result)) {
            $clogs = '';
            foreach ($result as $line => $info) {
                $clogs .= 'console.log(\'' . $info . '\');';
            }
            $exTools->addNewJavascript($clogs);
        }
    }
    
    public function loadClass($className) {
        if ( $className != null && !defined($className.'.class.php')  ) {
            if (file_exists('lib/classes/'.$className.'.class.php')) {
                require_once 'lib/classes/'.$className.'.class.php';
            } else {
                $currentModuleName = $this->getConf( 'safe_list')['modules'][$this->getCurrentModule()];
                $classPath = 'modules/'.$currentModuleName.'/lib/'.$className.'.class.php';

                if(  file_exists( $classPath) )  {
                    require_once $classPath;
                }
            } 
        }
    }

    /**
     * Verifica se a requisição é uma requisição ajax.
     */
    public static function isAjaxRequest() {
        $retorno = false;

        if (isset($_GET['ajaxRequest']) && $_GET['ajaxRequest'] == 'true') {
            $retorno = true;
        }

        return $retorno;
    }

    /**
     * Faz um var_export (um tipo de var_dump) para o console do firebug, com mensagem de ERRO.<br />
     * A função ira tratar os dados para evitar erros de javascript.<br />
     * Você pode passar o que quiser para um var_dump: object, array, string, ou outra coisa.<br />
     * Esta função aceita multiplos parametros.
     *
     * @param any $args
     */
    public static function cerror($args) {
        $ANHUR = Anhur::getInstance();
        $result = Anhur::dataforFirebugConsole(func_get_args());

        if (is_array($result)) {
            foreach ($result as $line => $info) {
                $ANHUR->page->onload('console.error(\'' . $info . '\');');
            }
        }
    }

    /**
     * Prepara os dados para mostra no console do firebug.<br />
     * Utilizada por clog() e crror().
     * 
     */
    private static function dataforFirebugConsole($args) {
        $array = $args;

        if (is_array($array)) {
            foreach ($array as $line => $info) {
                if (!is_string($info)) {
                    $info = print_r($info, 1);
                }
                $info = str_replace("\n", '\n', $info); //troca linha nova do php para javascript
                $info = str_replace("'", "\'", $info); // retira ' para evitar erros de sintaxe js
                $result[] = $info;
            }
        }

        return $result;
    }

    /**
     * Utiliza a classe externa dBug para mostrar um var_dump estilizado na tela.
     * 
     * @param any $variable Conteúdo que será mostrado na tela.
     */
    public static function vd($variable, $forceType = null) {
        include_once('lib/classes/dBug.class.php');

        if ($forceType != null) {
            new dBug($variable);
        } else {
            new dBug($variable, "$forceType");
        }
    }

    public static function getCurrentURL() {
        $amp = '&amp;';
        if ($server = $_SERVER['HTTP_HOST']) {
            $url = str_replace('&', $amp, 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']);
        }

        return $url;
    }

    public function getCurrentModule() {
        if (!isset($this->currentModule) && isset($_GET['module'])) {
            $this->currentModule = $_GET['module'];
        }

        return $this->currentModule;
    }

    public function getCurrentAction() {
        if (!isset($this->currentAction) && isset($_GET['action'])) {
            $this->currentAction = $_GET['action'];
        }
        return $this->currentAction;
    }

    public function getCurrentPage() {

        if (!isset($this->currentPage) && isset($_GET['pagina'])) {
            $this->currentPage = $_GET['pagina'];
        }

        return $this->currentPage;
    }

    public function setCurrentModule($currentModule) {
        $this->currentModule = $currentModule;
    }

    public function setCurrentPage($currentPage) {
        $this->currentPage = $currentPage;
    }

    public function setCurrentAction($currentAction) {
        $this->currentAction = $currentAction;
    }

    public static function assemblyURL() {
        $pageURL = 'http';
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $pageURL .= 's';
        }
        $pageURL .= '://';

        if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != '80') {
            $pageURL .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'];
        } else {
            $pageURL .= $_SERVER['SERVER_NAME'];
        }

        $pageURL .= substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '/?')) . '/?';

        if (self::getCurrentModule() != null) {
            $pageURL .= '&module=' . self::getCurrentModule();
        }
        if (self::getCurrentPage() != null) {
            $pageURL .= '&pagina=' . self::getCurrentPage();
        }


        return $pageURL;
    }

    public function getModuleConf( $moduleName) {
        return require_once( 'modules/'.$moduleName.'/etc/config.ini.php' );
    }

    public static function getModuleURL() {
        $pageURL = 'http';
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $pageURL .= 's';
        }
        $pageURL .= '://';

        if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != '80') {
            $pageURL .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'];
        } else {
            $pageURL .= $_SERVER['SERVER_NAME'];
        }

        $pageURL .= substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '/?')) . '/?';

        if (self::getCurrentModule() != null) {
            $pageURL .= '&module=' . self::getCurrentModule();
        }

        return $pageURL;
    }

    public static function getActionURL() {
        $pageURL = 'http';
        if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $pageURL .= 's';
        }
        $pageURL .= '://';

        if (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] != '80') {
            $pageURL .= $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'];
        } else {
            $pageURL .= $_SERVER['SERVER_NAME'];
        }

        $pageURL .= substr($_SERVER['REQUEST_URI'], 0, strpos($_SERVER['REQUEST_URI'], '/?')) . '/?';

        if (self::getCurrentModule() != null) {
            $pageURL .= '&module=' . self::getCurrentModule();
        }
        if (self::getCurrentPage() != null) {
            $pageURL .= '&pagina=' . self::getCurrentPage();
        }

        return $pageURL;
    }

}

new Anhur();
?>

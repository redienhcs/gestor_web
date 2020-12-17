<?php

/*******************************************************************************
 * LAST UPDATE
 * ============
 * Agosto, 09 2013
 *
 *
 * AUTHOR
 * =============
 * Anderson Felipe Schneider <hactar@universo.univates.br>
 * 
 * 
 * PURPOSE
 * =============
 * Facilitar a indexação de código javascript e css adicionais em uma página
 *
 *
 * USAGE
 * =============
 * $exTools = ExternalTools::getInstance();
 * 
 * //Javascript
 * $exTools->addNewJavascript("
 *  $('#btnEnviarNewsletter').click(function(){
 *       $('#emailUsuario').submit();
 *   });
 *   ");
 *
 * $exTools->addNewJavascript( '' , 'lib/imageSwitch.js');
 * 
 * //CSS
 * $exTools->addNewCss('','themes/pagination.css');
 * 
 * 
 * //para Adicionar o JS e o CSS dentro da página
 * Dentro da tag head - echo ( $exTools->createCss() );
 * Dentro da tag body - echo( $exTools->createJs() );
 * 
 * 
\*********************************************************************************************************************/

class ExternalTools {

    private static $selfInstance = null;
    private $javascript = array();
    private $css = array();

    public function  __construct() {
	self::$selfInstance = $this;
    }
    
    /**
     * Obtém uma instância da classe ExternalTools.
     */
    public static function getInstance() {
	return self::$selfInstance;
    }
    
    /**
     * Indexa um novo javascript dentro da página
     * Uso:
     * $exTools->addNewJavascript( '' , 'lib/imageSwitch.js');
     * $exTools->addNewJavascript("
     *  $('#btnEnviarNewsletter').click(function(){
     *       $('#emailUsuario').submit();
     *   });
     *   ");
     * 
     * @param $content javascript puro, será colocado dentro de uma tag javascript
     * @param $src caminho para um arquivo de código fonte javascript
     */
    public function addNewJavascript($content, $src = null) {
	$this->javascript[] = array('content' => $content, 'src' => $src);
    }
    
    /**
     * Cria os códigos javascript dentro da página do site. Colocar a função dentro do body.
     * Uso:
     * echo( $exTools->createJs() );
     */
    public function createJs() {
	$str = "";
	foreach ($this->javascript as $index => $js) {
	    $str .= "<script language=\"javascript\" type=\"text/javascript\" " . (($js['src']) ? "src=\"{$js['src']}\"" : "") . ">{$js['content']}</script>";
	}

	return $str;
    }
    
    /**
     * Indexa um novo css dentro da página
     * Uso:
     * $exTools->addNewCss('','themes/pagination.css');
     * 
     * @param $content css puro, será adicionado dentro do css
     * @param $src caminho para um arquivo de código fonte css
     * 
     */
    public function addNewCss($content, $src = null) {
	$this->css[] = array('content' => $content, 'src' => $src);
    }
    
    /**
     * Cria os códigos css dentro da página do site. Colocar esta função dentro da tag head
     * Uso:
     * echo ( $exTools->createCss() );
     */
    public function createCss() {
	$str = "";
	foreach ($this->css as $index => $style) {
	    if ($style['src']) {
		$str .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$style['src']}\" />";
	    } else
		$str .= "<style type=\"text/css\" " . (($style['src']) ? "src=\"{$style['src']}" : "") . ">{$style['content']}</style>";
	}

	return $str;
    }

}

new ExternalTools();
?>

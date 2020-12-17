<?php
/*******************************************************************************
 * ÚLTIMA ATUALIZAÇÃO
 * =============
 * Outubro, 01 2013
 *
 * AUTOR
 * =============
 * Anderson Felipe Schneider <hactar@universo.univates.br>
 * 
 * DESCRIÇÃO
 * =============
 * Classe que utiliza javascript e css para mostrar mensagens para o usuário.
 * Depende da classe ExternalTools e da biblioteca noty de notificações.
 * 
 * PROPÓSITO
 * =============
 * Facilitar o uso de notificações de informações para o usuário.
 *
 * USO
 * =============
 * $notificacoes = Notificacoes::getInstance();
 * $notificacoes->adicionarNotificacao('<p>Mensagem de sucesso</p>', Notificacoes::sucesso);
 * 
\*********************************************************************************************************************/

require_once 'ExternalTools.class.php';

class Notificacoes {
    
    private static $selfInstance = null;
    private static $externalTools = null;
    
    const alerta = 'alert';
    const informacao = 'information';
    const aviso = 'warning';
    const erro = 'error';
    const confirmacao = 'confirmation';
    const sucesso = 'success';
    
    private $message = array();
    
    public function  __construct() {
	self::$selfInstance = $this;
        self::$externalTools = ExternalTools::getInstance();
        self::$externalTools->addNewJavascript( '' , 'lib/noty/jquery.noty.js');
        self::$externalTools->addNewJavascript( '' , 'lib/noty/layouts/top.js');
        self::$externalTools->addNewJavascript( '' , 'lib/noty/layouts/topLeft.js');
        self::$externalTools->addNewJavascript( '' , 'lib/noty/layouts/topRight.js');
        self::$externalTools->addNewJavascript('','lib/noty/themes/default.js');
        self::$externalTools->addNewJavascript('','etc/noty.config.js');
    }

    /**
     * Obtém uma instância da classe de notificações.
     */
    public static function getInstance() {
	return self::$selfInstance;
    }
    
    /**
     * Adicionar uma nova notificação para o usuário.
     * Uso:
     * $notificacoes->adicionarNotificacao('<p>Mensagem de sucesso</p>', Notificacoes::sucesso);
     * 
     * @param $mensagem mensagem que será exibida para o usuário
     * @param $prioridade prioridade da mensagem/tipo da mensagem
     */
    public function adicionarNotificacao( $mensagem, $prioridade = 'information') {
        self::$externalTools->addNewJavascript('noty({text: \''.$mensagem.'\',type:\''.$prioridade.'\'});');
    }
    
}
    
new Notificacoes();
?>

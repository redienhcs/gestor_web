<?php
$_CFG = array();


/* Configuraçoes da base de dados
 */

$_CFG['database_conf'] = array();
$_CFG['database_conf']['username'] = '';
$_CFG['database_conf']['password'] = '';
$_CFG['database_conf']['server'] = '';
$_CFG['database_conf']['database'] = '';

$_CFG['client_info']['client_name']     = 'Anderson';
$_CFG['client_info']['client_email']    = 'hactar@universo.univates.br';
$_CFG['client_info']['client_website']    = 'ensino.univates.br/~hactar';

$_CFG['password_security']['default_iterations'] = 1000;
$_CFG['password_security']['default_algorithm'] = 'sha256';
$_CFG['password_security']['key_lenght'] = 32;


/*
 * Lista de modulos autorizados pelo sistema, onde o endereço no array e a url
 * que sera chamada e o conteudo da posiçao e a pasta a ser chamada e a pasta 
 * onde o sistema ira procurar pelos arquivos
 * EX:
 * $modulesList['fin'] = 'financas';
 * 
 * se $_GET['module'] for igual a fin, o sistema ira procurar o modulo financas
 */
$modulesList = array();
$modulesList['web'] = 'default';
$modulesList['gestor'] = 'webadmin';

// Carrega os modulos autorizados
$_CFG['safe_list']['modules'] = $modulesList;

/* Modulo padrao que sera chamado pelo sistema
 */
$_CFG['default_module'] = 'gestor';

define( 'DEF_DEBUG_VARIABLE' , 'T');
define( 'DEF_SIM' , 'T');
define( 'DEF_NAO' , 'F');



?>

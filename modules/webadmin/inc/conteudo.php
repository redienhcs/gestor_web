<?php

$safeList = array();
$safeList['home'] = 'home';
$safeList['logoff'] = 'logoff';
$safeList['autenticacao'] = 'login';

$objAnhur = Anhur::getInstance();
$objWebAdmin = WebAdmin::getInstance();

/*
 * 0 . TODO Essa verificação do login de usuário já é feita na classe webadmin
 */
if (!$objWebAdmin->verificarLoginUsuario()) {
    $objAnhur->setCurrentPage('autenticacao');
} elseif( $objAnhur->getCurrentPage() == NULL) {
    $objAnhur->setCurrentPage('home');
}

$pagina = $objAnhur->getCurrentPage();

if (!empty($pagina) && is_string($pagina) && isset($safeList[$pagina]) && file_exists("inc/{$safeList[$pagina]}.inc.php")) {
    return require_once 'inc/' . $safeList[$pagina] . '.inc.php';
} else {
    if (file_exists('inc/login.inc.php')) {
        return require_once 'inc/login.inc.php';
    }
}
?>
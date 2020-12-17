<?php

$objBusArquivo= new BusArquivo();

$notificacoes = Notificacoes::getInstance();

if( isset( $_GET['action']) ) {
    $action = strip_tags( trim( $_GET['action'] ) );
    
    switch ($action) {
        
        case 'uploadarquivo' :
            return require_once './inc/frm_arquivo.inc.php';
            break;
        case 'uploadfile' :
            if( Anhur::isAjaxRequest()) {
                return require_once './inc/uploadfile.inc.php';
            }
            break;
        default:
            return require_once './inc/grid_arquivo.inc.php';
            break;
    }
} else {
    return require_once './inc/grid_arquivo.inc.php';
}

?>

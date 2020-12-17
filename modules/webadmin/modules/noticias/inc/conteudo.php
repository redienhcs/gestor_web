<?php

$objBusNoticia = new busNoticia();

$notificacoes = Notificacoes::getInstance();

if( isset( $_GET['action']) ) {
    $action = strip_tags( trim( $_GET['action'] ) );
    //bjBusNoticia = new busNoticia();

    switch ($action) {
        case 'inserirnoticia':
        case 'novanoticia':
        case 'alterarnoticia':
        case 'salvnoti':
            require_once './inc/frm_noticia.inc.php';
            break;
        case 'removernoticia':
            /*
             0 . TODO Pedir confirmação do usuário sobre remoção da notícia.
             */
            if( isset( $_GET['cn'])) {
                $codigoDaNoticia = (int) ( isset($_GET['cn']) && !empty($_GET['cn'])) ? strip_tags(trim($_GET['cn'])) : 0;

                $objNoticia = new Noticia( );
                $objNoticia->setCodigoNoticia($codigoDaNoticia);
                if ($objNoticia->deletar()) {
                    $notificacoes->adicionarNotificacao('<p>Registro removido com sucesso.</p>', Notificacoes::sucesso);
                } else {
                    $notificacoes->adicionarNotificacao('<p>Erro ao remover o registro.</p>', Notificacoes::erro);
                }
            }
            
        default:
            require_once './inc/grid_noticia.inc.php';
            break;
    }
} else {
    require_once './inc/grid_noticia.inc.php';
}

?>

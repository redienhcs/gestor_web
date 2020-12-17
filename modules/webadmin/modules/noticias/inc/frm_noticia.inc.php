<?php
$errosEcontrados = false;

$notificacoes = Notificacoes::getInstance();

if( isset( $_GET['action']) && ( $_GET['action'] == 'inserirnoticia' || $_GET['action']=='salvnoti' )) {
    
    $objNoticia = new Noticia();
    
    if (isset($_POST['tituloNoticia']) && !empty($_POST['tituloNoticia'])) {
        $tituloDaNoticia = strip_tags(trim($_POST['tituloNoticia']));
        $objNoticia->setTitulo($tituloDaNoticia);
    } else {
        $errosEcontrados .= 'Título da notícia não foi informado.<br />';
    }

    if (isset($_POST['autorNoticia']) && !empty($_POST['autorNoticia'])) {
        $nomeAutor = strip_tags(trim($_POST['autorNoticia']));
        $objNoticia->setAutor($nomeAutor);
    } else {
        $errosEcontrados .= 'Autor da notícia não foi informado.<br />';
    }
    
    if (isset($_POST['dataNoticia']) && !empty($_POST['dataNoticia']) && DateClass::isValid( DateClass::convert( $_POST['dataNoticia'], '%d/%m/%Y', '%Y/%m/%d'), '%Y/%m/%d')) {
        $dataNoticia = strip_tags(trim($_POST['dataNoticia']));
        $objNoticia->setDataNoticia($dataNoticia);
    } else {
        $errosEcontrados .= 'Data da notícia não foi informada ou é inválida.<br />';
    }
    
    if (isset($_POST['conteudoNoticia']) && !empty($_POST['conteudoNoticia'])) {
        $conteudoNoticia = htmlentities(trim($_POST['conteudoNoticia']), ENT_NOQUOTES);
        $objNoticia->setConteudo($conteudoNoticia);
    }  else {
        $errosEcontrados .= 'Conteúdo da notícia não foi informado.<br />';
    }
    
    if( $errosEcontrados == false) {
        if( $_GET['action'] == 'inserirnoticia') {
            if( $objNoticia->inserir() ){
                $notificacoes->adicionarNotificacao('<p>Informações inseridas com sucesso.</p>', Notificacoes::sucesso);
                require_once 'grid_noticia.inc.php';
            } else {
                $notificacoes->adicionarNotificacao('<p>Erro ao inserir as informações na base de dados.</p>', Notificacoes::erro);
             }
        } else {
            
            $codigoDaNoticia = (int)( isset($_GET['cn']) && !empty($_GET['cn'])) ? strip_tags( trim($_GET['cn'])) :0;
            $objNoticia->setCodigoNoticia( $codigoDaNoticia);
            if( $objNoticia->alterar()) {
                $notificacoes->adicionarNotificacao('<p>Informações alteradas com sucesso.</p>', Notificacoes::sucesso);
                require_once 'grid_noticia.inc.php';
            } else {
                $notificacoes->adicionarNotificacao('<p>Erro ao alterar registro.</p>', Notificacoes::erro);
            }
        }
    }
}

$dadosFormulario = array();
if(  !(($_GET['action'] == 'inserirnoticia') || ( $_GET['action'] == 'salvnoti')) || $errosEcontrados != false) {
    if( isset( $_GET['action']) && $_GET['action'] == 'novanoticia') {
        echo '<h3>Cadastro de nova notícia</h3>';
        $dadosFormulario = $_POST;
    } else if(isset ( $_GET['action'])&& $_GET['action'] == 'alterarnoticia') {
        echo '<h3>Alteração de notícia</h3>';
        
        $codigoDaNoticia = (int)( isset($_GET['cn']) && !empty($_GET['cn'])) ? strip_tags( trim($_GET['cn'])) :0;
        
        $objNoticia = $objBusNoticia->obter( $codigoDaNoticia);
        
        $dadosFormulario['tituloNoticia'] = $objNoticia->getTitulo();
        $dadosFormulario['autorNoticia'] = $objNoticia->getAutor();
        $dadosFormulario['dataNoticia'] = $objNoticia->getDataNoticia();
        $dadosFormulario['conteudoNoticia'] = $objNoticia->getConteudo();
        
    }
    
    if( $errosEcontrados != false ) {
        $notificacoes->adicionarNotificacao('<h4>Alguns erros foram encontrados no formulário, por favor corrija e tente novamente:</h4>'.$errosEcontrados, Notificacoes::aviso);
        $dadosFormulario = $_POST;
    }
    
?>
<form class="formulariodomodulo" id="frmNoticia" name="formularioNoticia" action="?<?php echo Anhur::getModuleURL(); ?>&pagina=noticias&action=<?php echo $_GET['action']=='alterarnoticia' ? 'salvnoti&cn='.$_GET['cn']:'inserirnoticia' ?>" method="post">
    <label for="tituloNoticia">Título da notícia:</label><br />
    <input type="text" name="tituloNoticia" style="width: 300px; height: 20px; " id="tituloNoticia" value="<?php echo ( isset( $dadosFormulario['tituloNoticia'])) ? $dadosFormulario['tituloNoticia']: ''; ?>" />
    <br /><br />
    <label for="autoNoticia">Autor da notícia:</label><br />
    <input type="text" name="autorNoticia" style="width: 200px; height: 20px; " id="autorNoticia" value="<?php echo ( isset( $dadosFormulario['autorNoticia'])) ? $dadosFormulario['autorNoticia']: ''; ?>" />
    <br /><br />
    <label for="dataNoticia">Data da notícia:</label><br />
    <input type="text" name="dataNoticia" style="width: 80px; height: 20px; " id="dataNoticia" value="<?php echo ( isset( $dadosFormulario['dataNoticia'])) ? $dadosFormulario['dataNoticia']: ''; ?>" />
    <br /><br />
    <label for="conteudoNoticia">Conteúdo:</label><br />
    <textarea name="conteudoNoticia" id="conteudoNoticia" rows="4" cols="25"><?php echo ( isset( $dadosFormulario['conteudoNoticia'])) ? $dadosFormulario['conteudoNoticia']: ''; ?></textarea>
    <br /><br />
    <input type="submit" style="width: 50px; height: 25px;" value="Enviar" />
    <input type="button" style="width: 70px; height: 25px;" value="Cancelar" onclick="window.location='?<?php echo Anhur::getModuleURL(); ?>&pagina=noticias';" />
</form>
<?php
}

?>
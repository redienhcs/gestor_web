<?php

chdir( getcwd()."/modules/noticias");

$mysql = Mysql::getInstance();
$exTools = externalTools::getInstance();

require_once './business/busNoticia.php';
require_once './classes/Noticia.php';



ob_start();
?>
<div id="menuModuloNoticias" class="menuInterno">
    <ul>
        <li><a href="<?php echo Anhur::getActionURL(); ?>&action=novanoticia">Criar nova notícia</a></li>
    </ul>
</div>
<?php

require_once( './inc/conteudo.php');

$contents = ob_get_contents();
ob_end_clean();

return $contents;

?>

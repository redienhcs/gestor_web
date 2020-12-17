<?php

chdir( getcwd()."/modules/arquivos");

$mysql = Mysql::getInstance();
$exTools = externalTools::getInstance();

require_once './business/BusArquivo.php';
require_once './classes/Arquivo.class.php';

$conteudo = require_once( './inc/conteudo.php');

ob_start();
Anhur::assemblyURL();
?>
<div id="menuModuloArquivos" class="menuInterno">
    <ul>
        <li><a href="<?php echo Anhur::getActionURL(); ?>&action=uploadarquivo">Adicionar novo arquivo</a></li>
    </ul>
</div>
<?php

echo $conteudo;

$contents = ob_get_contents();
ob_end_clean();


return ( Anhur::isAjaxRequest()) ? $conteudo:$contents ;
?>

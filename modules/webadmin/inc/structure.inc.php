<?php
ob_start();
?>
<div id="menuPrincipal">
    <ul>
        <li><a href="<?php echo Anhur::getModuleUrl(); ?>&pagina=home">Home</a></li>
        <li><a href="<?php echo Anhur::getModuleUrl(); ?>&pagina=noticias">Notícias</a></li>
        <li><a href="<?php echo Anhur::getModuleUrl(); ?>&pagina=arquivos">Arquivos</a></li>
        <li><a href="<?php echo Anhur::getModuleUrl(); ?>&pagina=logoff">Logoff</a></li>
    </ul>
</div>    
<?php

$contents = ob_get_contents();
ob_end_clean();

return $contents;
?>
<?php

$mysql = Mysql::getInstance();
$exTools = externalTools::getInstance();

session_destroy();
ob_start();

echo 'Sessão encerrada.';

header("Location:?module=gestor");

$contents = ob_get_contents();
ob_end_clean();

return $contents;

?>
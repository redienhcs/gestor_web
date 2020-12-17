<?php

$exTools = externalTools::getInstance();

ob_start();

echo 'Modulo default';
echo 'nada?';


$contents = ob_get_contents();
ob_end_clean();

return $contents;
?>
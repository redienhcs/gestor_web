<?php

//$mysql = Mysql::getInstance();
$exTools = externalTools::getInstance();

ob_start();
echo 'Core Home';
$contents = ob_get_contents();
ob_end_clean();

return $contents;
?>

<?php

ob_start();

echo 'Modulo default';

$contents = ob_get_contents();
ob_end_clean();

return $contents;

?>


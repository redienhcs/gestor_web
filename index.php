<?php

require_once('lib/classes/Anhur.class.php');
$objAnhur = Anhur::getInstance();

$exTools = ExternalTools::getInstance();
$exTools->addNewCss('','themes/pagination.css');



$objAnhur = Anhur::getInstance();
$objAnhur->loadClass( 'dBug');

$conteudo = $objAnhur->getContents();



echo $conteudo;
?>

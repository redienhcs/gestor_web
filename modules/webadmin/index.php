<?php


$objAnhur = Anhur::getInstance();
$objAnhur->loadClass( 'WebAdmin');

$exTools = externalTools::getInstance ();
$notificacoes = Notificacoes::getInstance();

$objWebAdmin = WebAdmin::getInstance();
$conteudo = $objWebAdmin->getContents();

ob_start();
?>

<!DOCTYPE html>
<html>
    <head>
    <title>Módulo administrador</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="content-language" content="pt-br" />
    <meta name="description" content="Módulo gestor da web" />
    <meta name="keywords" content="" />
    <meta name="robots" content="noindex" />
    <meta name="googlebot-news" content="noindex" />
    <meta name="googlebot" content="noindex" />
    <meta name="author" content="Anderson Felipe Schneider <hactar@universo.univates.br>" />
    <link rel="stylesheet" type="text/css" href="themes/reset.source.css" />
    <link rel="stylesheet" type="text/css" href="themes/default.css" />
    <?php
	echo ( $exTools->createCss() );
	?>
  </head>
  
  <body>
      <div id="divPrincipal">
          <?php
          echo $conteudo;
          ?>          
      </div>
      
      <script type="text/javascript" src="lib/jquery.js"></script>
      <?php
      echo( $exTools->createJs() );
      ?>
      
  </body>
</html>
<?php

$contents = ob_get_contents();
ob_end_clean();

return ( Anhur::isAjaxRequest()) ? $conteudo :$contents;
?>

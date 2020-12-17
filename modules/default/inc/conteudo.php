<?php

$safeList = array();
$safeList['home'] = 'defaultPage';

if ( isset ( $_GET['pagina'] ) ) {
    $pagina = $_GET['pagina'];
} else {
    $pagina = '';
}


if( !empty($pagina) && is_string( $pagina) && isset( $safeList[$pagina]) && file_exists( "inc/{$safeList[$pagina]}.inc.php" ) ) {
    return require_once( 'inc/'.$safeList[$pagina].'.inc.php' );
} else {
    if(file_exists( 'inc/home.inc.php')) {
        return require_once( 'inc/home.inc.php' );
    }
    
}

?>
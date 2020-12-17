<?php

$safeList = array();
$safeList['web'] = 'default';
$safeList['gestor'] = 'webadmin';

if ( isset ( $_GET['module'] ) ) {
    $module = $_GET['module'];
} else {
    $module = '';
}



if( !empty($module) && is_string( $module) && isset( $safeList[$module]) && file_exists( 'modules/'.$safeList[$module].'/index.php' ) ) {
    return require_once( 'modules/'.$safeList[$module].'/index.php' );
} else {
    if(file_exists( 'modules/default/index.php')) {
        return require_once( 'modules/default/index.php' );
    }
}

?>
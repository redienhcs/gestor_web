<?php

$_CFG = array();
$webAdminSafeList = array();
$webAdminSafeList['home'] = 'home';
$webAdminSafeList['autenticacao'] = 'login';


$_CFG['safe_list']['webadmin'] = $webAdminSafeList;

return $_CFG;

?>

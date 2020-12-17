<?php

$objAnhur = Anhur::getInstance();
$objWebAdmin = WebAdmin::getInstance();

$objSession = SecureSessionHandler::getInstance();

switch ($objAnhur->getCurrentAction()) {
    case 'frmusuario':
        break;
    case 'insert':
        echo 'inserir -editar';
    //require_once('business/BusUsuario.class.php');
    case 'change':
        break;

    case 'login':
        if (isset($_POST['emailUsuario']) && isset($_POST['emailUsuario'])) {

            /*
              0 . TODO Sanitizar variáveis.
             */
            require_once 'business/BusUsuario.class.php';
            $objUsuario = (new BusUsuario())->obter($_POST['emailUsuario']);
            //$arrayPassword = $objAnhur->encryptPassword( $_POST['senhaUsuario']);

            $hashCalculado = $objAnhur->encryptPassword($_POST['senhaUsuario'], $objUsuario->getUsua_salto(), $objUsuario->getUsua_iteracoes());

            if ($objUsuario->getUsua_hash() == $hashCalculado['hash']) {
                $objSession->put('usua_codigo', $objUsuario->getUsua_codigo());
                $objAnhur->setCurrentPage('home');
                $objAnhur->setcurrentAction(null);
            }
        } else {
            $objAnhur->setCurrentPage('autenticacao');
            $objAnhur->setcurrentAction(null);
        }
        
        return $objWebAdmin->getContents();
        
    case 'logoff':
        $objSession->forget();
        
        $objAnhur = Anhur::getInstance();
    default:
        return require_once 'forms/frmLogin.php';
        break;
}


?>
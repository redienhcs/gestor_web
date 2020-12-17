<?php



require_once('../lib/classes/SecureSessionHandler.class.php');

$session->start();

if (!$session->isValid(5)) {
    $session->destroy();
}
echo $session->get('hello.world');
require_once('simpletest/autorun.php');



class TestOfSecureSessionHandler extends UnitTestCase {

    function testCriarNovaSessao() {
        $session = SecureSessionHandler::getInstance();
        $session->start();

        if (!$session->isValid(5)) {
            $session->destroy();
        }
    }

}
//new TestOfSecureSessionHandler($session);
?>
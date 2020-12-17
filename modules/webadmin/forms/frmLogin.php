<?php

ob_start();

?>

<p>Login de usuário</p>
<form id="formularioLogin" name="formularioLogin" action="?module=gestor&pagina=autenticacao&action=login" method="post">
    <label class="label" for="emailUsuario">Email de usuário</label><br />
    <input type="text" name="emailUsuario" style="width: 200px; height: 20px; " id="emailUsuario" value=""/>
    <br />
    <label for="senhaUsuario">Senha</label><br />
    <input type="password" name="senhaUsuario" style="width: 200px; height: 20px; " id="senhaUsuario" value=""/>
    <br />
    <input type="submit" style="width: 50px; height: 25px;" value="Login" />
</form>

<?php
$contents = ob_get_contents();
ob_end_clean();

return $contents;

?>
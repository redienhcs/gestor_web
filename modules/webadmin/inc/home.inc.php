<?php


Anhur::clog('teste');


ob_start();
?>
<h3>Bem vindo ao módulo de administração</h3>
<p>Use os menus para fazer alterações no seu webiste. Caso tiver algum problema ou dúvida sobre o gestor e o site, acesse o menu lateral e clique em contato.</p>

<p>Página HOME</p>
<a href="?module=gestor&pagina=autenticacao&action=logoff">Logoff</a>
<?php

$contents = ob_get_contents();
ob_end_clean();

return $contents;
?>
<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = '
<h4>Visão geral</h4>
<p>O módulo de complementos permite aos administradores enviar, e gerir módulos de terceiros.</p>

<h4>Enviar complemento</h4>
<p>Os novos módulos devem estar comprimidos num ficheiro zip e a pasta deve ser nomeada com o mesmo que o módulo.<br>
Por exemplo, se está a carregar o módulo "forums" a pasta deve ser nomeada com "forums" não "test_forums".</p>

<h4>Desactivar ou desinstalar um módulo</h4>
<p>Se quiser remover um módulo do front-end e dos menus de administração, pode desativar o módulo.<br>
Se quiser apagar completamente pode desinstalá-lo.<br>
<font color="red">Atenção: A desinstalação de um módulo exclui todos os ficheiros fonte, os ficheiros enviados, e os registros da base de dados associados com o módulo.</font></p>
';
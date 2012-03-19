<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = '
<h4>Visão geral</h4>
<p>O módulo de complementos permite aos administradores enviar, e gerenciar módulos de terceiros.</p>

<h4>Enviando</h4>
<p>Novos módulos devem estar em um arquivo zip e a pasta deve ser nomeada com o mesmo que o módulo.<br>
Por exemplo, se você está carregando o módulo "forums" a pasta deve ser nomeada com "forums" não "test_forums".</p>

<h4>Desabilitando ou desinstalando um módulo</h4>
<p>Se você quiser remover um módulo do front-end e dos menus de administração que você pode desativar o módulo.<br>
Se você quiser terminar com ele completamente você pode desinstalá-lo.<br>
<font color="red">Atenção: A desinstalação de um módulo exclui todos os arquivos fonte, os arquivos enviados, e os registros do banco de dados associados com o módulo.</font></p>
';
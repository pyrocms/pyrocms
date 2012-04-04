<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = '
<h4>Visão geral</h4>
<p>O módulo de navegação controla a sua área de navegação principal assim como outros grupos de links.</p>

<h4>Grupos de navegação</h4>
<p>Links de navegação são mostrados de acordo com o grupo em que eles estão. Em muitos temas o grupo "Header" é o grupo de navegação principal. 
Verifique a documentação do seu tema para encontrar que grupos de navegação são suportados nos ficheiros do tema. 
Se precisar de mostrar um grupo dentro do conteúdo do site, use uma tag como esta: {{ navigation:links group="nome-do-seu-grupo" }}</p>

<h4>Adicionar links</h4>
<p>Selecione o grupo onde deseja adicionar um novo link, em seguida escreva um título para o seu link e selecione um tipo.
Os tipos de links são os seguintes:
<ul>
<li>URL: um link externo - http://google.com</li>
<li>Link do site: um link do seu site - galleries/portfolio-pictures</li>
<li>Módulo: leva o visitante para página de índice do módulo escolhido</li>
<li>Página: link para uma página</li>
</ul>
O campo Destino determina se o link deve ser aberto em uma nova janela ou aba.
(Dica: use Nova janela com moderação para evitar irritar os visitantes do seu site.)
O campo Classe permite que adicione nome de classes CSS para este link.</p>
<p></p>

<h4>Ordenar os links de navegação</h4>
<p>A ordem dos seus links no painel de administrador serão refletidas no front-end do site.
Para mudar a ordem com que eles aparecem simplesmente arraste e solte até que estejam na ordem que você quer.</p>';
<?php defined('BASEPATH') or exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = '
<h4>Visão geral</h4>
<p>O módulo páginas é uma simples, mas poderosa ferramenta para gerir o conteúdo estático do seu site.
Types de página podem ser geridos e widgets incorporados sem nunca editar os ficheiros de template.</p>

<h4>Gerir páginas</h4><hr>
<h6>Conteúdo da página</h6>
<p>Ao escolher o título da página lembre-se que o layout de página padrão deverá mostrá-lo acima do conteúdo da página.
Agora vamos criar o conteúdo da página usando o editor WYSIWYG.
Quando estiver pode configurar se a página será visivel para os visitantes, defina a situação como "Pública" e ela será acessível pela URL mostrada.
<strong>Também deve ir até Design -> Navegação e criar um novo link de navegação se quiser para que a sua página seja vista a partir do menu.</strong></p>

<h6>Metadados</h6>
<p>O meta título é geralmente usado como o título dos resultados de pesquisa e também acredita-se que têm um peso significativo no posicionamento da página.<br />
Meta palavras-chave são palavras que descrevem o conteúdo do seu site e são um benefício para os mecanismos de pesquisa.<br />
A meta descrição é uma curta descrição da página e poderá ser usada como o trecho do resultado de busca, se o motor de busca considerar relevante para a pesquisa.</p>

<h6>Design</h6>
<p>A aba Design permite que selecione um layout de página personalizado e opcionalmente aplique diferentes estilos CSS apenas para tal página.
Consulte a seção sobre páginas de layout, logo abaixo, para obter instruções sobre como usar melhor este recurso.</p>

<h6>Script</h6>
<p>Pode colocar algum JavaScript aqui, o que você o quiser anexado ao <head> da página.</p>

<h6>Opções</h6>
<p>Permite que habilite configurações individuais para página, como comentários e feed RSS.
Se o feed RSS for habilitado um visitante poderá assinar esta página e receber cada subpágina em um leitor RSS.</p>

<h6>Revisões</h6>
<p>Revisões é um recurso muito poderoso e acessível para editar uma página existente.
Digamos que um novo administrador estragou a edição de uma página.
Basta selecionar uma data que você gostaria de reverter a página e clicar em Salvar!
Pode até mesmo comparar as revisões para ver o que mudou.</p>

<h4>Types de página</h4><hr>
<p>Types de página permite que controle o layout da página sem modificar os seus ficheiros do tema.
Pode incorporar marcações dentro do layout de página em vez de colocar dentro de cada página.
Por exemplo: Se tem um widget de feed do Twitter que deseja mostrar na parte inferior de cada página pode apenas adicioná-lo num layout de página:
<pre><code>
{{ page:title }}
{{ page:body }}

&lt;div class=&quot;my-twitter-widget&quot;&gt;
	{{ widgets:instance id=&quot;1&quot; }}
&lt;/div&gt;
</code></pre>
Agora  pode aplicar uma estilização CSS para a classe "meu-widget-do-twitter" na aba CSS.</p>';
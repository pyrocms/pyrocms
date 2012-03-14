<?php defined('BASEPATH') OR exit('No direct script access allowed');

// inline help html. Only 'help_body' is used.
$lang['help_body'] = '
<h4>Visão geral</h4>
<p>O módulo páginas é uma simples, mas poderosa ferramenta para gerenciar o conteúdo estático do seu site.
Layouts de página podem ser gerenciados e widgets incorporados sem nunca editar os arquivos de template.</p>

<h4>Gerenciando páginas</h4><hr>
<h6>Conteúdo de página</h6>
<p>Ao escolher o título da página lembre-se que o layout de página padrão deverá mostrá-lo acima do conteúdo da página.
Agora vamos criar o conteúdo da página usando o editor WYSIWYG.
Quando você estiver de que a página será visivel para os visitantesdefina a situação como "Pública" e ela será acessível pela URL mostrada. 
<strong>Você também deve ir até Design -> Navegação e criar um novo link de navegação se quiser que sua página seja vista a partir do menu.</strong></p>

<h6>Metadados</h6>
<p>O meta título é geralmente usado como o título dos resultados de pesquisa e também acredita-se que têm um peso significativo no posicionamento de página.<br />
Meta palavras-chave são palavras que descrevem o conteúdo do seu site e são um benefício para os mecanismos de pesquisa.<br />
A meta descrição é uma curta descrição da página e poderá ser usada como o trecho do resultado de busca, se o motor de busca considerar relevante para a pesquisa.</p>

<h6>Design</h6>
<p>A aba Design permite que você selecione um layout de página personalizado e opcionalmente aplique diferentes estilos CSS apenas para tal página. 
Consulte a seção sobre páginas de layout, logo abaixo, para obter instruções sobre como usar melhor este recurso.</p>

<h6>Script</h6>
<p>Você pode colocar algum JavaScript aqui que você o quiser anexado ao <head> da página.</p>

<h6>Opções</h6>
<p>Permite que você habilite configurações individuais para página, como comentários e feed RSS. 
Se o feed RSS for habilitado um visitante poderá assinar esta página e receber cada subpágina em um leitor RSS.</p>

<h6>Revisões</h6>
<p>Revisões é um recurso muito poderoso e acessível para editar uma página existente.
Digamos que um novo funcionário realmente bagunçou uma edição de página.
Basta selecionar uma data que você gostaria de reverter a página e clicar em Salvar!
Você pode até mesmo comparar as revisões para ver o que mudou.</p>

<h4>Layouts de página</h4><hr>
<p>Layouts de página permite que você controle o layout da página sem modificar os seus arquivos do tema. 
Você pode incorporar marcações dentro do layout de página em vez de colocar dentro de cada página. 
Por exemplo: Se você tem um widget de feed do Twitter que deseja mostrar na parte inferior de cada página você pode apenas adicioná-lo num layout de página:
<pre><code>
{{ page:title }}
{{ page:body }}

< div class="meu-widget-do-twitter" >
	{{ widgets:instance id="1" }}
< /div >
</code></pre>
Agora você pode aplicar uma estilização CSS para a classe "meu-widget-do-twitter" na aba CSS.</p>';
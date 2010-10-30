<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']			=	'Passo 2: Verificar requerimentos';
$lang['intro_text']		= 	'O primeiro passo no processo de instalação é checar se o seu servidor suporta o PyroCMS. A maioria dos servidores costumam suporta-lo sem maiores problemas.';
$lang['mandatory']		= 	'Mandatory'; #translate
$lang['recommended']	= 	'Recommended'; #translate

$lang['server_settings']= 	'Configurações do Servidor HTTP';
$lang['server_version']	=	'Seu programa de Servidor:';
$lang['server_fail']	=	'Seu programa de servidor não é suportado, mesmo assim o PyroCMS pode ( ou não ) funcionar. Se a instalação do seu PHP e MySQL estão atualizados,o PyroCMS deverá rodar perfeitamente, apenas sem URL\'s limpas.';

$lang['php_settings']	=	'Configurações do PHP';
$lang['php_required']	=	'PyroCMS necessita de PHP com versão 5.0 ou superior.';
$lang['php_version']	=	'Seu servidor está rodando esta versão';
$lang['php_fail']		=	'A versão do seu PHP não é suportada. O PyroCMS necessita de um PHP versão 5.0 ou superior para rodar corretamente.';

$lang['mysql_settings']	=	'Configurações do MySQL';
$lang['mysql_required']	=	'PyroCMS necessita acesso a um banco de dados MySQL com versão 5.0 ou superior.';
$lang['mysql_version1']	=	'Seu servidor está rodando atualmente';
$lang['mysql_version2']	=	'Seu cliente está rodando atualmente';
$lang['mysql_fail']		=	'Sua versão de MySQL não é suportada. O PyroCMS necessita de um MySQL versão 5.0 ou superior para rodar corretamente.';

$lang['gd_settings']	=	'Configurações do GD';
$lang['gd_required']	= 	'PyroCMS necessita da biblioteca GD versão 1.0 ou superior para manipular imagens.';
$lang['gd_version']		= 	'Seu servidor está rodando a versão';
$lang['gd_fail']		=	'Não conseguimos determinar a versão da sua biblioteca GD. Isto normalmente quer dizer que a biblioteca GD não está instalada. O PyroCMS irá funcionar perfeitamente, porém, as funções de imagens poderão não funcionar. É altamente recomendável habilitar a biblioteca GD.';

$lang['summary']		=	'Resumo';

$lang['zlib']			=	'Zlib'; #translate
$lang['zlib_required']	= 	'PyroCMS requires Zlib in order to unzip and install themes.'; #translate
$lang['zlib_fail']		=	'Zlib can not be found. This usually means that Zlib is not installed. PyroCMS will still run properly but installation of themes will not work. It is highly recommended to install Zlib.'; #translate

$lang['curl']			=	'Curl'; #translate
$lang['curl_required']	=	'PyroCMS requires Curl in order to make connections to other sites.'; #translate
$lang['curl_fail']		=	'Curl can not be found. This usually means that Curl is not installed. PyroCMS will still run properly but some of the functions might not work. It is highly recommended to enable the Curl library.'; #translate

$lang['summary_success']	=	'Seu servidor atende a todos os requisitos do PyroCMS para rodar corretamente, siga para o próximo passo clicando no botão abaixo.';
$lang['summary_partial']	=	'Seu servidor atende a <em>quase</em> todos os requisitos do PyroCMS. Isto significa que o PyroCMS poderá rodar corretamente, porém, existe uma chance de você experimentar problemas com coisas relativas a manipulação de imagens e criação de miniaturas.';
$lang['summary_failure']	=	'Parece que o seu servidor falhou ao atender aos requisitos para rodar o PyroCMS. Por favor, contate o seu administrador de servidor ou empresa de hosepedagem para resolver este problema.';
$lang['next_step']		=	'Siga para o próximo passo';
$lang['step3']			=	'Passo 3';
$lang['retry']			=	'Tente novamente';

// messages
$lang['step1_failure']	=	'Por favor, preencha os campos relativos a configuração do banco de dados no formulário abaixo..';

/* End of file step_2_lang.php */
/* Location: ./installer/language/brazlilian/step_2_lang.php */
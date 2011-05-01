<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

// labels
$lang['header']				= '2ª Etapa: Verificação de requesitos';
$lang['intro_text']			= 'O segundo passo no processo de instalação é checar se o seu servidor suporta o PyroCMS. A maioria dos servidores costumam suporta-lo sem maiores problemas.';
$lang['mandatory']			= 'Obrigatório';
$lang['recommended']		= 'Recomendado';

$lang['server_settings']	= 'Configurações do Servidor HTTP';
$lang['server_version']		= 'Seu programa de Servidor:';
$lang['server_fail']		= 'Seu programa de servidor não é suportado, mesmo assim o PyroCMS pode ( ou não ) funcionar. Se a instalação do seu PHP e MySQL estão atualizados,o PyroCMS deverá rodar perfeitamente, apenas sem URL\'s limpas.';

$lang['php_settings']		= 'Configurações do PHP';
$lang['php_required']		= 'PyroCMS necessita de PHP com versão 5.0 ou superior.';
$lang['php_version']		= 'Seu servidor está rodando esta versão';
$lang['php_fail']			= 'A versão do seu PHP não é suportada. O PyroCMS necessita de um PHP versão 5.0 ou superior para rodar corretamente.';

$lang['mysql_settings']		= 'Configurações do MySQL';
$lang['mysql_required']		= 'PyroCMS necessita acesso a um banco de dados MySQL com versão 5.0 ou superior.';
$lang['mysql_version1']		= 'Seu servidor está rodando atualmente';
$lang['mysql_version2']		= 'Seu cliente está rodando atualmente';
$lang['mysql_fail']			= 'Sua versão de MySQL não é suportada. O PyroCMS necessita de um MySQL versão 5.0 ou superior para rodar corretamente.';

$lang['gd_settings']		= 'Configurações do GD';
$lang['gd_required']		= 'PyroCMS necessita da biblioteca GD versão 1.0 ou superior para manipular imagens.';
$lang['gd_version']			= 'Seu servidor está rodando a versão';
$lang['gd_fail']			= 'Não conseguimos determinar a versão da sua biblioteca GD. Isto normalmente quer dizer que a biblioteca GD não está instalada. O PyroCMS irá funcionar perfeitamente, porém, as funções de imagens poderão não funcionar. É altamente recomendável habilitar a biblioteca GD.';

$lang['summary']			= 'Resumo';

$lang['zlib']				= 'Zlib';
$lang['zlib_required']		= 'PyroCMS necessita da biblioteca Zlib para descomprimir e instalar temas.';
$lang['zlib_fail']			= 'A biblioteca Zlib não foi encontrada. Isso normalmente quer dizer que a biblioteca Zlib não está instalada. O PyroCMS irá funcionar perfeitamente, porém, a instalação de temas não vai funcionar. É altamente recomendável habilitar a biblioteca Zlib.';

$lang['curl']				= 'Curl';
$lang['curl_required']		= 'PyroCMS necessita da biblioteca Curl para poder se conectar a outros sites.';
$lang['curl_fail']			= 'A bilioteca Curl não foi encontrada. Isso normalmente quer dizer que a biblioteca Curl não está instalada. O PyroCMS irá funcionar, porém, mas algumas funcionalidades podem falhar. É altamente recomendável habilitar a biblioteca Curl.';

$lang['summary_success']	= 'Seu servidor atende a todos os requisitos do PyroCMS para rodar corretamente, siga para o próximo passo clicando no botão abaixo.';
$lang['summary_partial']	= 'Seu servidor atende a <em>quase</em> todos os requisitos do PyroCMS. Isto significa que o PyroCMS poderá rodar corretamente, porém, existe uma chance de você experimentar problemas com coisas relativas a manipulação de imagens e criação de miniaturas.';
$lang['summary_failure']	= 'Parece que o seu servidor falhou ao atender aos requisitos para rodar o PyroCMS. Por favor, contate o seu administrador de servidor ou empresa de hosepedagem para resolver este problema.';

$lang['next_step']			= 'Siga para a próxima etapa';
$lang['step3']				= '3ª Etapa';
$lang['retry']				= 'Tente novamente';

// messages
$lang['step1_failure']		= 'Por favor, preencha os campos relativos a configuração do banco de dados no formulário abaixo..';

/* End of file step_2_lang.php */
/* Location: ./installer/language/brazlilian/step_2_lang.php */
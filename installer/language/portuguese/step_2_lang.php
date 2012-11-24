<?php defined('BASEPATH') OR exit('No direct script access allowed');

// labels
$lang['header']				= '2ª Etapa: Requisitos necessários';
$lang['intro_text']			= 'O segundo passo no processo de instalação é verificar se o ambiente do seu servidor atende os requisitos obrigatórios e recomendados para o funcionamento correto do PyroCMS. A maioria dos servidores suportam estes requisitos sem maiores problemas.';
$lang['mandatory']			= 'Obrigatórios';
$lang['recommended']		= 'Recomendados';

$lang['server_settings']	= 'Configurações do Servidor HTTP';
$lang['server_version']		= 'O seu programa de Servidor:';
$lang['server_fail']		= 'O seu programa de servidor não é suportado, mesmo assim o PyroCMS pode ( ou não ) funcionar. Se a instalação do seu PHP e MySQL estão actualizados, o PyroCMS deverá funcionar perfeitamente, apenas sem URL\'s limpas.';

$lang['php_settings']		= 'Configurações do PHP';
$lang['php_required']		= 'O PyroCMS precisa do PHP na versão %s ou superior.';
$lang['php_version']		= 'O seu servidor está a usar a versão';
$lang['php_fail']			= 'Actualmente o PyroCMS precisa da versão %s ou superior do PHP para funcionar corretamente.';

$lang['mysql_settings']		= 'Configurações do MySQL';
$lang['mysql_required']		= 'O PyroCMS precisa de acesso a uma base de dados MySQL na versão 5.0 ou superior.';
$lang['mysql_version1']		= 'O seu servidor MySQL está a usar a versão';
$lang['mysql_version2']		= 'O seu cliente MySQL está a usar a versão';
$lang['mysql_fail']			= 'A sua versão do MySQL não é suportado. O PyroCMS necessita de um MySQL na versão 5.0 ou superior para funcionar corretamente.';

$lang['gd_settings']		= 'Configurações do GD';
$lang['gd_required']		= 'O PyroCMS recomenda ter a biblioteca GD na versão 1.0 ou superior para manipulação de imagens.';
$lang['gd_version']			= 'O seu servidor está a usar a versão';
$lang['gd_fail']			= 'Não conseguimos determinar a versão da sua biblioteca GD. Isto normalmente quer dizer que a biblioteca GD não está instalada. O PyroCMS irá funcionar perfeitamente, porém, as funções de imagens poderão não funcionar. É altamente recomendável habilitar a biblioteca GD.';

$lang['summary']			= 'Resumo';

$lang['zlib']				= 'Zlib';
$lang['zlib_required']		= 'O PyroCMS recomenda ter a biblioteca Zlib para descomprimir e instalar recursos adicionais no Painel de Controlo.';
$lang['zlib_fail']			= 'A biblioteca Zlib não foi encontrada. Isso normalmente quer dizer que a biblioteca Zlib não está instalada. O PyroCMS irá funcionar perfeitamente, porém, a instalação de temas não vai funcionar. É altamente recomendável habilitar a biblioteca Zlib.';

$lang['curl']				= 'Curl';
$lang['curl_required']		= 'O PyroCMS recomenda ter a biblioteca Curl para poder se conectar a outros sites.';
$lang['curl_fail']			= 'A bilioteca Curl não foi encontrada. Isso normalmente quer dizer que a biblioteca Curl não está instalada. O PyroCMS irá funcionar, porém, mas algumas funcionalidades podem falhar. É altamente recomendável habilitar a biblioteca Curl.';

$lang['summary_success']	= 'O seu servidor atende a todos os requisitos do PyroCMS para funcionar corretamente, siga para o próximo passo clicando no botão em baixo.';
$lang['summary_partial']	= 'O seu servidor atende a <em>quase</em> todos os requisitos do PyroCMS. Isto significa que o PyroCMS poderá funcionar corretamente, porém, existe uma chance de encontrar problemas com coisas relativas a manipulação de imagens e criação de miniaturas.';
$lang['summary_failure']	= 'Parece que o seu servidor falhou ao atender aos requisitos para usar o PyroCMS. Por favor, contacte o seu administrador do servidor ou empresa de hosting para resolver este problema.';

$lang['next_step']			= 'Ir para a próxima etapa';
$lang['step3']				= '3ª Etapa';
$lang['retry']				= 'Tente novamente';

// messages
$lang['step1_failure']		= 'Por favor, preencha os campos relacionados á configuração da base de dados no formulário abaixo..';

/* End of file step_2_lang.php */
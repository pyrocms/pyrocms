<?php defined('BASEPATH') OR exit('No direct script access allowed');

#section settings
$lang['settings:site_name'] 					= 'Nome do site';
$lang['settings:site_name_desc'] 				= 'O nome do website para títulos de páginas e para usar por todo o site.';

$lang['settings:site_slogan'] 					= 'Slogan do site';
$lang['settings:site_slogan_desc'] 				= 'O slogan do website para títulos de páginas e para usar por todo o site.';

$lang['settings:site_lang']						= 'Idioma do site';
$lang['settings:site_lang_desc']				= 'O idioma nativo do website, usado para escolher modelos de e-mail para notificações internas e recebimento de contato dos visitantes além de outras funcionalidades que não devem se flexionar ao idioma de um usuário.';

$lang['settings:contact_email'] 				= 'E-mail de contato';
$lang['settings:contact_email_desc'] 			= 'Todos os e-mails de usuários, visitantes e do site irão para este endereço.';

$lang['settings:server_email'] 					= 'E-mail do servidor';
$lang['settings:server_email_desc'] 			= 'Todos e-mails para usuários virão deste endereço de e-mail.';

$lang['settings:meta_topic']					= 'Meta tema';
$lang['settings:meta_topic_desc']				= 'Duas ou três palavras descrevendo o tipo de empresa/website.';

$lang['settings:currency'] 						= 'Moeda';
$lang['settings:currency_desc'] 				= 'O símbolo monetário para usar em produtos, serviços, etc.';

$lang['settings:dashboard_rss'] 				= 'RSS Feed do Dashboard';
$lang['settings:dashboard_rss_desc'] 			= 'Link para um feed RSS que deve ser mostrado no dashboard.';

$lang['settings:dashboard_rss_count'] 			= 'Itens RSS do Dashboard';
$lang['settings:dashboard_rss_count_desc'] 		= 'Quantos itens RSS devem ser mostrados no dashboard?';

$lang['settings:date_format'] 					= 'Formato de data';
$lang['settings:date_format_desc'] 				= 'Como devem ser exibidas as datas em todo o site e painel de controle? ' .
													'Utilize o <a href="http://php.net/manual/en/function.date.php" target="_black">formato de data</a> PHP - OU - ' .
													'Utilize o formato de <a href="http://php.net/manual/en/function.strftime.php" target="_black">strings formatadas como data</a> do PHP.';

$lang['settings:frontend_enabled'] 				= 'Situação do site';
$lang['settings:frontend_enabled_desc'] 		= 'Use esta opção para definir se a frente do site ficará visível ou não. Últil quando houver a necessidade de desligar o site para manutenção.';

$lang['settings:mail_protocol'] 				= 'Protocolo de e-mail';
$lang['settings:mail_protocol_desc'] 			= 'Selecione o protocolo de e-mail desejado.';

$lang['settings:mail_sendmail_path'] 			= 'Caminho do Sendmail';
$lang['settings:mail_sendmail_path_desc']		= 'Caminho para o sendmail.';

$lang['settings:mail_smtp_host'] 				= 'Host do SMTP';
$lang['settings:mail_smtp_host_desc'] 			= 'O nome do host do seu servidor SMTP.';

$lang['settings:mail_smtp_pass'] 				= 'Senha do SMTP';
$lang['settings:mail_smtp_pass_desc'] 			= 'A senha do SMTP.';

$lang['settings:mail_smtp_port'] 				= 'Porta do SMTP';
$lang['settings:mail_smtp_port_desc'] 			= 'O número da porta do SMTP.';

$lang['settings:mail_smtp_user'] 				= 'Usuário do SMTP';
$lang['settings:mail_smtp_user_desc'] 			= 'O nome de usuário do SMTP.';

$lang['settings:unavailable_message']			= 'Mensagem de indisponibilidade';
$lang['settings:unavailable_message_desc'] 		= 'Quando o site for desligado ou houver um problema maior, esta mensagem deverá aparecer para os usuários.';

$lang['settings:default_theme'] 				= 'Tema padrão';
$lang['settings:default_theme_desc'] 			= 'Selecione o tema que você quer que os usuários vejam por padrão.';

$lang['settings:activation_email'] 				= 'E-mail de ativação';
$lang['settings:activation_email_desc'] 		= 'Envia um e-mail com link de ativação quando o usuário cadastrar. Desative isto para que apenas administradores ativem as contas.';

$lang['settings:records_per_page'] 				= 'Registros por página';
$lang['settings:records_per_page_desc'] 		= 'Quantos registros nos devemos mostrar por página na secão administrativa?';

$lang['settings:rss_feed_items'] 				= 'Quantidade de itens do Feed';
$lang['settings:rss_feed_items_desc'] 			= 'Quantos itens nos devemos mostrar nos feeds de RSS/novidades?';


$lang['settings:enable_profiles'] 				= 'Ativar perfis';
$lang['settings:enable_profiles_desc'] 			= 'Permitir que usuários adicionem e editem perfis.';

$lang['settings:ga_email'] 						= 'E-mail do Google Analytic';
$lang['settings:ga_email_desc']					= 'E-mail utilizado para o Google Analytics, é necessário para mostrar o gráfico no dashboard.';

$lang['settings:ga_password'] 					= 'Senha do Google Analytic';
$lang['settings:ga_password_desc']				= 'Senha do Google Analytics. Isso também é necessária para mostrar o gráfico no dashboard.';

$lang['settings:ga_profile'] 					= 'Perfil do Google Analytic';
$lang['settings:ga_profile_desc']				= 'ID do Perfil para este site no Google Analytics.';

$lang['settings:ga_tracking'] 					= 'Cód. de acompanhamento Google';
$lang['settings:ga_tracking_desc']				= 'Digite seu código de acompanhamento do Google Analytics para ativar a captura de dados do Google Analytics. Ex.: UA-19483569-6';

$lang['settings:twitter_username'] 				= 'Nome de usuário';
$lang['settings:twitter_username_desc'] 		= 'Nome de usuário do Twitter.';

$lang['settings:twitter_feed_count'] 			= 'Contador do Feed';
$lang['settings:twitter_feed_count_desc'] 		= 'Quantos tweets devem ser retornados para o bloco de feed do Twitter?';

$lang['settings:twitter_cache'] 				= 'Tempo de cache';
$lang['settings:twitter_cache_desc'] 			= 'Quantos minutos seus Tweets devem ser armazenados temporariamente?';

$lang['settings:akismet_api_key'] 				= 'Chave da API do Akismet';
$lang['settings:akismet_api_key_desc'] 			= 'Akismet é um bloqueador de spam da equipe WordPress. Isto mantém spam sobre controle sem forçar que usuários façam a confirmação humana de CAPTCHA nos formulários.';

$lang['settings:comment_order'] 				= 'Ordenar comentários';
$lang['settings:comment_order_desc']			= 'A ordem de classificação no qual exibir comentários.';

$lang['settings:enable_comments'] 				= 'Permitir comentários';
$lang['settings:enable_comments_desc']			= 'Permitir que usuários publiquem comentários?';

$lang['settings:moderate_comments'] 			= 'Moderar comentários';
$lang['settings:moderate_comments_desc']		= 'Forçar comentários a serem aprovados antes que apareçan no site.';

$lang['settings:comment_markdown']				= 'Permitir Markdown';
$lang['settings:comment_markdown_desc']			= 'Você permite que usuários publiquem comentários utilizando Markdown?';

$lang['settings:version'] 						= 'Versão';
$lang['settings:version_desc'] 					= '';

$lang['settings:site_public_lang']				= 'Idiomas públicos';
$lang['settings:site_public_lang_desc']			= 'Quais são os idiomas realmente suportados e oferecidos no front-end do seu website?';

$lang['settings:admin_force_https']				= 'Forçar HTTPS para o Painel de Controle?';
$lang['settings:admin_force_https_desc']		= 'Permitir apenas o protocolo HTTPS ao acessar o Painel de Controle?';

$lang['settings:files_cache']					= 'Cache de Arquivos';
$lang['settings:files_cache_desc']				= 'Ao exibir imagens via site.com/files, qual deve ser o tempo de expiração do cache?';

$lang['settings:auto_username']					= 'Nome de Usuário Automático';
$lang['settings:auto_username_desc']			= 'Cria automaticamente um nome de usuário, assim usuários não precisam criar um durante o registro.';

$lang['settings:registered_email']				= 'E-mail de registro de usuário';
$lang['settings:registered_email_desc']			= 'Envia um e-mail de notificação para o e-mal de contato quando alguém se registra.';

$lang['settings:ckeditor_config']               = 'Configuração do CKEditor';
$lang['settings:ckeditor_config_desc']          = 'Você pode encontrar uma lista de itens válidos de configuração na <a target="_blank" href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html">documentação do CKEditor.</a>';

$lang['settings:enable_registration']           = 'Habilitar registro de usuários';
$lang['settings:enable_registration_desc']      = 'Permite que usuários se registrem no seu site.';

$lang['settings:profile_visibility']            = 'Visibilidade de Perfis';
$lang['settings:profile_visibility_desc']       = 'Especifique quem pode ver os perfis de usuário no site público.';

$lang['settings:cdn_domain']                    = 'Domínio CDN';
$lang['settings:cdn_domain_desc']               = 'Domínios CDN permitem descarregar o conteúdo estático para vários servidores de ponta, como a Amazon CloudFront ou MaxCDN. If you do not have a CDN provider try MaxCDN. <a href="'.CDN_OFFER_URL.'" target="_blank">Sign up and save 25%.</a>'; #translate

$lang['settings:files_enabled_providers']       = 'Provedores de hospedagem de arquivos habilitados';
$lang['settings:files_enabled_providers_desc']  = 'Quais provedores de hospedagem de arquivos você quer habilitar? (Se você habilitar um provedor de nuvem você deve fornecer as chaves de autenticação válidas abaixo.)';

$lang['settings:files_s3_access_key']           = 'Chave de Acesso do Amazon S3';
$lang['settings:files_s3_access_key_desc']      = 'Para habilitar armazenamento de arquivos na nuvem na sua conta Amazon S3, forneça sua Chave de Acesso. <a href="https://aws-portal.amazon.com/gp/aws/securityCredentials#access_credentials">Descubra suas credenciais.</a>';

$lang['settings:files_s3_secret_key']           = 'Chave Secreta do Amazon S3';
$lang['settings:files_s3_secret_key_desc']      = 'Você também deve fornecer sua Chave Secreta Amazon S3. Você a encontra no mesmo local da sua Chave de Acesso na sua conta Amazon.';

$lang['settings:files_s3_url']                  = 'URL do Amazon S3';
$lang['settings:files_s3_url_desc']             = 'Mude esta URL se estiver usando um dos locais da Amazon na Europa ou um domínio personalizado.';

$lang['settings:files_s3_geographic_location']     = 'Localização Geográfica da Amazon S3';
$lang['settings:files-s3_geographic_location_url'] = 'Estados Unidos (US) ou Europa (EU). Se você mudar esta opção, também deverá mudar a URL do S3.';

$lang['settings:files_cf_username']             = 'Nome de Usuário do Rackspace Cloud Files';
$lang['settings:files_cf_username_desc']        = 'Para habilitar armazenamento de arquivos na nuvem na sua conta Rackspace Cloud Files, por favor, insira seu Nome de Usuário do Cloud Files. <a href="https://manage.rackspacecloud.com/APIAccess.do">Descubra suas credenciais.</a>';

$lang['settings:files_cf_api_key']              = 'Chave da API do Rackspace Cloud Files';
$lang['settings:files_cf_api_key_desc']         = 'Você precisa fornecer também sua Chave da API do Cloud Files. Você a encontra no mesmo local de seu Nome de Usuário na sua conta do Rackspace.';

$lang['settings:files_upload_limit']            = 'Limite de Tamanho de Arquivo';
$lang['settings:files_upload_limit_desc']       = 'Tamanho máximo de arquivo permitido ao fazer upload. Especifique o valor em MB. Exemplo: 5';

#section titles
$lang['settings:section_general']				= 'Geral';
$lang['settings:section_integration']			= 'Integração';
$lang['settings:section_comments']				= 'Comentários';
$lang['settings:section_users']					= 'Usuários';
$lang['settings:section_statistics']			= 'Estatísticas';
$lang['settings:section_twitter']				= 'Twitter';
$lang['settings:section_files']					= 'Arquivos';

#checkbox and radio options
$lang['settings:form_option_Open']				= 'Aberto';
$lang['settings:form_option_Closed']			= 'Fechado';
$lang['settings:form_option_Enabled']			= 'Ativo';
$lang['settings:form_option_Disabled']			= 'Desativado';
$lang['settings:form_option_Required']			= 'Obrigatório';
$lang['settings:form_option_Optional']			= 'Opcional';
$lang['settings:form_option_Oldest First']		= 'Antigos primeiro';
$lang['settings:form_option_Newest First']		= 'Novos primeiro';
$lang['settings:form_option_Text Only']			= 'Apenas Texto';
$lang['settings:form_option_Allow Markdown']	= 'Permitir Markdown';
$lang['settings:form_option_Yes']				= 'Sim';
$lang['settings:form_option_No']				= 'Não';
$lang['settings:form_option_profile_public']	= 'Visível para todos';
$lang['settings:form_option_profile_owner']		= 'Visível apenas para o dono do perfil';
$lang['settings:form_option_profile_hidden']	= 'Nunca visível';
$lang['settings:form_option_profile_member']	= 'Visível para qualquer usuário logado';
$lang['settings:form_option_activate_by_email'] = 'Ativação por e-mail';
$lang['settings:form_option_activate_by_admin'] = 'Ativação por um Admin';
$lang['settings:form_option_no_activation']     = 'Ativação instantânea';
$lang['settings:form_option_no-cache']          = 'Sem cache';
$lang['settings:form_option_1-minute']          = '1 minuto';
$lang['settings:form_option_1-hour']            = '1 hora';
$lang['settings:form_option_3-hour']            = '3 horas';
$lang['settings:form_option_8-hour']            = '8 horas';
$lang['settings:form_option_1-day']             = '1 dia';
$lang['settings:form_option_30-days']           = '30 dias';
$lang['settings:form_option_United States']     = 'Estados Unidos';
$lang['settings:form_option_Europe']            = 'Europa';

// titles
$lang['settings:edit_title']					= 'Editar configurações';

// messages
$lang['settings:no_settings']					= 'Atualmente não há configurações.';
$lang['settings:save_success']					= 'Suas configurações foram salvas!';

/* End of file settings_lang.php */
<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['settings_save_success']					= 'Suas configurações foram salvas!';
$lang['settings_edit_title']					= 'Editar configurações';

#section settings
$lang['settings_site_name'] 					= 'Nome do site';
$lang['settings_site_name_desc'] 				= 'O nome do website para títulos de páginas e para usar por todo o site.';

$lang['settings_site_slogan'] 					= 'Slogan do site';
$lang['settings_site_slogan_desc'] 				= 'O slogan do website para títulos de páginas e para usar por todo o site.';

$lang['settings_site_lang']						= 'Idioma do site';
$lang['settings_site_lang_desc']				= 'O idioma nativo do website, usado para escolher modelos de e-mail para notificações internas e recebimento de contato dos visitantes além de outras funcionalidades que não devem se flexionar ao idioma de um usuário.';

$lang['settings_contact_email'] 				= 'E-mail de contato';
$lang['settings_contact_email_desc'] 			= 'Todos os e-mails de usuários, visitantes e do site devem ir para este endereço.';

$lang['settings_server_email'] 					= 'Servidor de e-mail';
$lang['settings_server_email_desc'] 			= 'Todos e-mails para usuários devem ir para este endereço de e-mail.';

$lang['settings_meta_topic']					= 'Meta tema';
$lang['settings_meta_topic_desc']				= 'Duas ou três palavras descrevendo o tipo de empresa/website.';

$lang['settings_currency'] 						= 'Moeda';
$lang['settings_currency_desc'] 				= 'O símbolo monetário para usar em produtos, serviços, etc.';

$lang['settings_dashboard_rss'] 				= 'RSS Feed do Dashboard';
$lang['settings_dashboard_rss_desc'] 			= 'Link para um feed RSS que deve ser mostrado no dashboard.';

$lang['settings_dashboard_rss_count'] 			= 'Itens RSS do Dashboard';
$lang['settings_dashboard_rss_count_desc'] 		= 'Quantos itens RSS devem ser mostrados no dashboard?';

$lang['settings_date_format'] 					= 'Formato de data';
$lang['settings_date_format_desc'] 				= 'Como devem ser exibidas as datas em todo o site e painel de controle? ' .
													'Utilize o <a href="http://php.net/manual/en/function.date.php" target="_black">formato de data</a> PHP - OU - ' .
													'Utilize o formato de <a href="http://php.net/manual/en/function.strftime.php" target="_black">strings formatadas como data</a> do PHP.';

$lang['settings_frontend_enabled'] 				= 'Situação do site';
$lang['settings_frontend_enabled_desc'] 		= 'Use esta opção para definir se a frente do site ficará visível ou não. Últil quando houver a necessidade de desligar o site para manutenção.';

$lang['settings_mail_protocol'] 				= 'Protocolo de e-mail';
$lang['settings_mail_protocol_desc'] 			= 'Selecione o protocolo de e-mail desejado.';

$lang['settings_mail_sendmail_path'] 			= 'Caminho do Sendmail';
$lang['settings_mail_sendmail_path_desc']		= 'Caminho para o sendmail.';

$lang['settings_mail_smtp_host'] 				= 'Host do SMTP';
$lang['settings_mail_smtp_host_desc'] 			= 'O nome do host do seu servidor SMTP.';

$lang['settings_mail_smtp_pass'] 				= 'Senha do SMTP';
$lang['settings_mail_smtp_pass_desc'] 			= 'A senha do SMTP.';

$lang['settings_mail_smtp_port'] 				= 'Porta do SMTP';
$lang['settings_mail_smtp_port_desc'] 			= 'O número da porta do SMTP.';

$lang['settings_mail_smtp_user'] 				= 'Usuário do SMTP';
$lang['settings_mail_smtp_user_desc'] 			= 'O nome de usuário do SMTP.';

$lang['settings_unavailable_message']			= 'Mensagem de indisponibilidade';
$lang['settings_unavailable_message_desc'] 		= 'Quando o site for desligado ou houver um problema maior, esta mensagem deverá aparecer para os usuários.';

$lang['settings_default_theme'] 				= 'Tema padrão';
$lang['settings_default_theme_desc'] 			= 'Selecione o tema que você quer que os usuários vejam por padrão.';

$lang['settings_activation_email'] 				= 'E-mail de ativação';
$lang['settings_activation_email_desc'] 		= 'Enviar um e-mail com link de ativação quando o usuário cadastrar. Desative isto para que apenas administradores ativem as contas.';

$lang['settings_records_per_page'] 				= 'Registros por página';
$lang['settings_records_per_page_desc'] 		= 'Quantos registros nos devemos mostrar por página na secão administrativa?';

$lang['settings_rss_feed_items'] 				= 'Quantidade de itens do Feed';
$lang['settings_rss_feed_items_desc'] 			= 'Quantos itens nos devemos mostrar nos feeds de RSS/novidades?';

$lang['settings_require_lastname'] 				= 'Sobrenomes obrigatórios?';
$lang['settings_require_lastname_desc'] 		= 'Em algumas situações, um sobrenome pode não ser necessário. Você deseja forçar os usuários a digita-lo ou não?';

$lang['settings_enable_profiles'] 				= 'Ativar perfis';
$lang['settings_enable_profiles_desc'] 			= 'Permitir que usuários adicionem e editem perfis.';

$lang['settings_ga_email'] 						= 'E-mail do Google Analytic';
$lang['settings_ga_email_desc']					= 'E-mail utilizado para o Google Analytics, é necessário para mostrar o gráfico no dashboard.';

$lang['settings_ga_password'] 					= 'Senha do Google Analytic';
$lang['settings_ga_password_desc']				= 'Senha do Google Analytics. Isso também é necessária para mostrar o gráfico no dashboard.';

$lang['settings_ga_profile'] 					= 'Perfil do Google Analytic';
$lang['settings_ga_profile_desc']				= 'ID do Perfil para este site no Google Analytics.';

$lang['settings_ga_tracking'] 					= 'Cód. de acompanhamento Google';
$lang['settings_ga_tracking_desc']				= 'Digite seu código de acompanhamento do Google Analytics para ativar a captura de dados do Google Analytics. Ex.: UA-19483569-6';

$lang['settings_twitter_username'] 				= 'Nome de usuário';
$lang['settings_twitter_username_desc'] 		= 'Nome de usuário do Twitter.';

$lang['settings_twitter_consumer_key'] 			= 'Chave de consumo';
$lang['settings_twitter_consumer_key_desc'] 	= 'Chave de consumo do Twitter.';

$lang['settings_twitter_consumer_key_secret'] 	= 'Chave de consumo secreta';
$lang['settings_twitter_consumer_key_secret_desc'] = 'Chave de consumo secreta do Twitter.';

$lang['settings_twitter_blog']					= 'Twitter integrado ao Blog.';
$lang['settings_twitter_blog_desc'] 			= 'Você deseja que sejam escritos automaticamente no twitter os links para os novos artigos do blog?';

$lang['settings_twitter_feed_count'] 			= 'Contador do Feed';
$lang['settings_twitter_feed_count_desc'] 		= 'Quantos tweets devem ser retornados para o bloco de feed do Twitter?';

$lang['settings_twitter_cache'] 				= 'Tempo de cache';
$lang['settings_twitter_cache_desc'] 			= 'Quantos minutos seus Tweets devem ser armazenados temporariamente?';

$lang['settings_akismet_api_key'] 				= 'Chave da API do Akismet';
$lang['settings_akismet_api_key_desc'] 			= 'Akismet é um bloqueador de spam da equipe WordPress. Isto mantém spam sobre controle sem forçar que usuários façam a confirmação humana de CAPTCHA nos formulários.';

$lang['settings_comment_order'] 				= 'Ordenar comentários';
$lang['settings_comment_order_desc']			= 'A ordem de classificação no qual exibir comentários.';

$lang['settings_enable_comments'] 				= 'Permitir comentários';
$lang['settings_enable_comments_desc']			= 'Permite a escrita de comentários';

$lang['settings_moderate_comments'] 			= 'Moderar comentários';
$lang['settings_moderate_comments_desc']		= 'Forçar comentários a serem aprovados antes que apareçan no site.';

$lang['settings_version'] 						= 'Versão';
$lang['settings_version_desc'] 					= '';

#section titles
$lang['settings_section_general']				= 'Geral';
$lang['settings_section_integration']			= 'Integração';
$lang['settings_section_comments']				= 'Comentários';
$lang['settings_section_users']					= 'Usuários';
$lang['settings_section_statistics']			= 'Estatísticas';
$lang['settings_section_twitter']				= 'Twitter';

#checkbox and radio options
$lang['settings_form_option_Open']				= 'Aberto';
$lang['settings_form_option_Closed']			= 'Fechado';
$lang['settings_form_option_Enabled']			= 'Ativo';
$lang['settings_form_option_Disabled']			= 'Desativado';
$lang['settings_form_option_Required']			= 'Obrigatório';
$lang['settings_form_option_Optional']			= 'Opcional';
$lang['settings_form_option_Oldest First']		= 'Antigos primeiro';
$lang['settings_form_option_Newest First']		= 'Novos primeiro';

/* End of file settings_lang.php */
/* Location: ./system/cms/modules/settings/language/brazilian/settings_lang.php */

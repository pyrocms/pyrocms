<?php defined('BASEPATH') OR exit('No direct script access allowed');

#section settings
$lang['settings:site_name'] 					= 'Nome do site';
$lang['settings:site_name_desc'] 				= 'O nome do website para títulos de páginas e para usar por todo o site.';

$lang['settings:site_slogan'] 					= 'Slogan do site';
$lang['settings:site_slogan_desc'] 				= 'O slogan do website para títulos de páginas e para usar por todo o site.';

$lang['settings:site_lang']						= 'Idioma do site';
$lang['settings:site_lang_desc']				= 'O idioma nativo do website, usado para escolher modelos de e-mail para notificações internas e recebimento de contato dos visitantes além de outras funcionalidades que não devem se flexionar ao idioma de um usuário.';

$lang['settings:contact_email'] 				= 'E-mail de contato';
$lang['settings:contact_email_desc'] 			= 'Todos os e-mails de usuários, visitantes e do site devem ir para este endereço.';

$lang['settings:server_email'] 					= 'Servidor de e-mail';
$lang['settings:server_email_desc'] 			= 'Todos e-mails para usuários devem ir para este endereço de e-mail.';

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
$lang['settings:activation_email_desc'] 		= 'Enviar um e-mail com link de ativação quando o usuário cadastrar. Desative isto para que apenas administradores ativem as contas.';

$lang['settings:records_per_page'] 				= 'Registros por página';
$lang['settings:records_per_page_desc'] 		= 'Quantos registros nos devemos mostrar por página na secão administrativa?';

$lang['settings:rss_feed_items'] 				= 'Quantidade de itens do Feed';
$lang['settings:rss_feed_items_desc'] 			= 'Quantos itens nos devemos mostrar nos feeds de RSS/novidades?';

$lang['settings:require_lastname'] 				= 'Sobrenomes obrigatórios?';
$lang['settings:require_lastname_desc'] 		= 'Em algumas situações, um sobrenome pode não ser necessário. Você deseja forçar os usuários a digita-lo ou não?';

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
$lang['settings:enable_comments_desc']			= 'Permite a escrita de comentários';

$lang['settings:moderate_comments'] 			= 'Moderar comentários';
$lang['settings:moderate_comments_desc']		= 'Forçar comentários a serem aprovados antes que apareçan no site.';

$lang['settings:version'] 						= 'Versão';
$lang['settings:version_desc'] 					= '';

$lang['settings:ckeditor_config']               = 'CKEditor Config'; #translate
$lang['settings:ckeditor_config_desc']          = 'You can find a list of valid configuration items in <a target="_blank" href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html">CKEditor\'s documentation.</a>'; #translate

$lang['settings:enable_registration']           = 'Enable user registration'; #translate
$lang['settings:enable_registration_desc']      = 'Allow users to register in your site.'; #translate

$lang['settings:profile_visibility']            = 'Profile Visibility'; #translate
$lang['settings:profile_visibility_desc']       = 'Specify who can view user profiles on the public site'; #translate

$lang['settings:cdn_domain']                    = 'CDN Domain'; #translate
$lang['settings:cdn_domain_desc']               = 'CDN domains allow you to offload static content to various edge servers, like Amazon CloudFront or MaxCDN.'; #translate

#section titles
$lang['settings:section_general']				= 'Geral';
$lang['settings:section_integration']			= 'Integração';
$lang['settings:section_comments']				= 'Comentários';
$lang['settings:section_users']					= 'Usuários';
$lang['settings:section_statistics']			= 'Estatísticas';
$lang['settings:section_twitter']				= 'Twitter';

#checkbox and radio options
$lang['settings:form_option_Open']				= 'Aberto';
$lang['settings:form_option_Closed']			= 'Fechado';
$lang['settings:form_option_Enabled']			= 'Ativo';
$lang['settings:form_option_Disabled']			= 'Desativado';
$lang['settings:form_option_Required']			= 'Obrigatório';
$lang['settings:form_option_Optional']			= 'Opcional';
$lang['settings:form_option_Oldest First']		= 'Antigos primeiro';
$lang['settings:form_option_Newest First']		= 'Novos primeiro';
$lang['settings:form_option_profile_public']	= 'Visible to everybody'; #translate
$lang['settings:form_option_profile_owner']		= 'Only visible to the profile owner'; #translate
$lang['settings:form_option_profile_hidden']	= 'Never visible'; #translate
$lang['settings:form_option_profile_member']	= 'Visible to any logged in user'; #translate
$lang['settings:form_option_activate_by_email']        	= 'Activate by email'; #translate
$lang['settings:form_option_activate_by_admin']        	= 'Activate by admin'; #translate
$lang['settings:form_option_no_activation']         	= 'Instant activation'; #translate

// titles
$lang['settings:edit_title']					= 'Editar configurações';

// messages
$lang['settings:no_settings']					= 'There are currently no settings.'; #translate
$lang['settings:save_success']					= 'Suas configurações foram salvas!';

/* End of file settings_lang.php */
<?php defined('BASEPATH') OR exit('No direct script access allowed');

#section settings
$lang['settings_site_name'] 					= 'Nome do site';
$lang['settings_site_name_desc'] 				= 'O nome do website para títulos de páginas e para usar por todo o site.';

$lang['settings_site_slogan'] 					= 'Slogan do site';
$lang['settings_site_slogan_desc'] 				= 'O slogan do website para títulos de páginas e para usar por todo o site.';

$lang['settings_site_lang']						= 'Idioma do site';
$lang['settings_site_lang_desc']				= 'O idioma nativo do website, usado para escolher modelos de e-mail para notificações internas e recebimento de contato dos visitantes além de outras funcionalidades que não devem se flexionar ao idioma de um utilizador.';

$lang['settings_contact_email'] 				= 'E-mail de contacto';
$lang['settings_contact_email_desc'] 			= 'Todos os e-mails de utilizadores, visitantes e do site devem ir para este endereço.';

$lang['settings_server_email'] 					= 'Servidor de e-mail';
$lang['settings_server_email_desc'] 			= 'Todos e-mails para utilizadores devem ir para este endereço de e-mail.';

$lang['settings_meta_topic']					= 'Meta tema';
$lang['settings_meta_topic_desc']				= 'Duas ou três palavras descrevendo o tipo de empresa/website.';

$lang['settings_currency'] 						= 'Moeda';
$lang['settings_currency_desc'] 				= 'O símbolo monetário para usar em produtos, serviços, etc.';

$lang['settings_dashboard_rss'] 				= 'RSS Feed do Dashboard';
$lang['settings_dashboard_rss_desc'] 			= 'Link para um feed RSS que deve ser mostrado no dashboard.';

$lang['settings_dashboard_rss_count'] 			= 'Itens RSS do Dashboard';
$lang['settings_dashboard_rss_count_desc'] 		= 'Quantos itens RSS devem ser mostrados no dashboard?';

$lang['settings_date_format'] 					= 'Formato da data';
$lang['settings_date_format_desc'] 				= 'Como devem ser exibidas as datas em todo o site e no painel de controlo? ' .
													'Utilize o <a href="http://php.net/manual/en/function.date.php" target="_black">formato de data</a> PHP - OU - ' .
													'Utilize o formato de <a href="http://php.net/manual/en/function.strftime.php" target="_black">strings formatadas como data</a> do PHP.';

$lang['settings_frontend_enabled'] 				= 'Situação do site';
$lang['settings_frontend_enabled_desc'] 		= 'Use esta opção para definir se a frente do site ficará visível ou não. Últil quando houver a necessidade de desligar o site para manutenção.';

$lang['settings_mail_protocol'] 				= 'Protocolo de e-mail';
$lang['settings_mail_protocol_desc'] 			= 'Seleccione o protocolo de e-mail desejado.';

$lang['settings_mail_sendmail_path'] 			= 'Caminho do Sendmail';
$lang['settings_mail_sendmail_path_desc']		= 'Caminho para o sendmail.';

$lang['settings_mail_smtp_host'] 				= 'Host do SMTP';
$lang['settings_mail_smtp_host_desc'] 			= 'O nome do host do seu servidor SMTP.';

$lang['settings_mail_smtp_pass'] 				= 'Password do SMTP';
$lang['settings_mail_smtp_pass_desc'] 			= 'A password do SMTP.';

$lang['settings_mail_smtp_port'] 				= 'Porta do SMTP';
$lang['settings_mail_smtp_port_desc'] 			= 'O número da porta do SMTP.';

$lang['settings_mail_smtp_user'] 				= 'Utilizador do SMTP';
$lang['settings_mail_smtp_user_desc'] 			= 'O nome de utilizafor do SMTP.';

$lang['settings_unavailable_message']			= 'Mensagem de indisponibilidade';
$lang['settings_unavailable_message_desc'] 		= 'Quando o site for desligado ou houver um problema maior, esta mensagem deverá aparecer para os utilizadores.';

$lang['settings_default_theme'] 				= 'Tema padrão';
$lang['settings_default_theme_desc'] 			= 'Selecione o tema que quer que os utilizadores vejam por padrão.';

$lang['settings_activation_email'] 				= 'E-mail de activação';
$lang['settings_activation_email_desc'] 		= 'Enviar um e-mail com link de activação quando um utilizador se registar. Desactive isto para que apenas administradores activem as contas.';

$lang['settings_records_per_page'] 				= 'Registos por página';
$lang['settings_records_per_page_desc'] 		= 'Quantos registos nos devemos mostrar por página na seccão administrativa?';

$lang['settings_rss_feed_items'] 				= 'Quantidade de itens do Feed';
$lang['settings_rss_feed_items_desc'] 			= 'Quantos itens nos devemos mostrar nos feeds de RSS/novidades?';

$lang['settings_require_lastname'] 				= 'Sobrenomes obrigatórios?';
$lang['settings_require_lastname_desc'] 		= 'Em algumas situações, um sobrenome pode não ser necessário. Deseja forçar os utilizadores a digita-lo ou não?';

$lang['settings_enable_profiles'] 				= 'Activar perfis';
$lang['settings_enable_profiles_desc'] 			= 'Permitir que utilizadores adicionem e editem perfis.';

$lang['settings_ga_email'] 						= 'E-mail do Google Analytic';
$lang['settings_ga_email_desc']					= 'E-mail utilizado para o Google Analytics, é necessário para mostrar o gráfico no dashboard.';

$lang['settings_ga_password'] 					= 'Password do Google Analytic';
$lang['settings_ga_password_desc']				= 'Password do Google Analytics. Isso também é necessária para mostrar o gráfico no dashboard.';

$lang['settings_ga_profile'] 					= 'Perfil do Google Analytic';
$lang['settings_ga_profile_desc']				= 'ID do Perfil para este site no Google Analytics.';

$lang['settings_ga_tracking'] 					= 'Cód. de acompanhamento Google';
$lang['settings_ga_tracking_desc']				= 'Digite o seu código de acompanhamento do Google Analytics para ativar a captura de dados do Google Analytics. Ex.: UA-19483569-6';

$lang['settings_twitter_username'] 				= 'Nome de utilizador';
$lang['settings_twitter_username_desc'] 		= 'Nome de utilizador do Twitter.';

$lang['settings_twitter_feed_count'] 			= 'Contador do Feed';
$lang['settings_twitter_feed_count_desc'] 		= 'Quantos tweets devem ser retornados para o bloco de feed do Twitter?';

$lang['settings_twitter_cache'] 				= 'Tempo de cache';
$lang['settings_twitter_cache_desc'] 			= 'Quantos minutos os seus Tweets devem ser armazenados temporariamente?';

$lang['settings_akismet_api_key'] 				= 'Chave da API do Akismet';
$lang['settings_akismet_api_key_desc'] 			= 'Akismet é um bloqueador de spam da equipa WordPress. Isto mantém spam sobre controle sem forçar que utilizadores façam a confirmação humana de CAPTCHA nos formulários.';

$lang['settings_comment_order'] 				= 'Ordenar comentários';
$lang['settings_comment_order_desc']			= 'A ordem de classificação na qual quer exibir os comentários.';

$lang['settings_enable_comments'] 				= 'Permitir comentários';
$lang['settings_enable_comments_desc']			= 'Permite a escrita de comentários no site';

$lang['settings_moderate_comments'] 			= 'Moderar comentários';
$lang['settings_moderate_comments_desc']		= 'Forçar todos os comentários a serem aprovados antes que apareçam no site.';

$lang['settings_comment_markdown']				= 'Permitir Markdown';
$lang['settings_comment_markdown_desc']			= 'Quer permitir que os visitantes possão inserir comentários com Markdown?';

$lang['settings_version'] 						= 'Versão';
$lang['settings_version_desc'] 					= '';

$lang['settings_site_public_lang']				= 'Idiomas públicos';
$lang['settings_site_public_lang_desc']			= 'Quais são as línguas realmente suportadas e oferecidas no front-end do seu site?';

$lang['settings_admin_force_https']				= 'Forçar HTTPS para o Painel de Controlo?';
$lang['settings_admin_force_https_desc']		= 'Permitir apenas HTTPS protocol quando usa o Painel de Controlo?';

$lang['settings_files_cache']					= 'Cache Ficheiros';
$lang['settings_files_cache_desc']				= 'Quando a saída de uma imagem através de site.com/files, devemos definir a expiração de cache para?';

$lang['settings_auto_username']					= 'Auto Username';
$lang['settings_auto_username_desc']			= 'Cria o utilizador automaticamente, ou seja, os utilizadores podem ignonar isto ao fazer o registo.';

$lang['settings_registered_email']				= 'Email de registo de Utilizador';
$lang['settings_registered_email_desc']			= 'Enviar um e-mail de notificação para o contacto de e-mail quando alguém se regista.';

$lang['settings_ckeditor_config']               = 'Config CKEditor';
$lang['settings_ckeditor_config_desc']          = 'Pode encontrar uma lista de itens de configuração válidos em <a target="_blank" href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html">CKEditor\'s documentação</a>.';

$lang['settings_enable_registration']           = 'Habilitar o registro de utilizadores';
$lang['settings_enable_registration_desc']      = 'Permitir que os utilizadores se registem no seu site.';

$lang['settings_cdn_domain']                    = 'CDN Domain';
$lang['settings_cdn_domain_desc']               = 'CDN domínios permite descarregar conteúdos estáticos para servidores de borda diferentes, como, Amazon CloudFront ou MaxCDN.';

#section titles
$lang['settings_section_general']				= 'Geral';
$lang['settings_section_integration']			= 'Integração';
$lang['settings_section_comments']				= 'Comentários';
$lang['settings_section_users']					= 'Utilizadores';
$lang['settings_section_statistics']			= 'Estatísticas';
$lang['settings_section_twitter']				= 'Twitter';
$lang['settings_section_files']					= 'Ficheiros';

#checkbox and radio options
$lang['settings_form_option_Open']				= 'Aberto';
$lang['settings_form_option_Closed']			= 'Fechado';
$lang['settings_form_option_Enabled']			= 'Activo';
$lang['settings_form_option_Disabled']			= 'Desactivado';
$lang['settings_form_option_Required']			= 'Obrigatório';
$lang['settings_form_option_Optional']			= 'Opcional';
$lang['settings_form_option_Oldest First']		= 'Antigos primeiro';
$lang['settings_form_option_Newest First']		= 'Novos primeiro';
$lang['settings_form_option_Text Only']			= 'Apenas Texto';
$lang['settings_form_option_Allow Markdown']	= 'Permitir Markdown';
$lang['settings_form_option_Yes']				= 'Sim'; 
$lang['settings_form_option_No']				= 'Não';


// messages
$lang['settings_no_settings']					= 'Atualmente não existem definições.';
$lang['settings_save_success']					= 'As suas configurações foram salvas!';

/* End of file settings_lang.php */
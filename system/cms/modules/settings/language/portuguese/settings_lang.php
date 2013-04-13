<?php defined('BASEPATH') OR exit('No direct script access allowed');

#section settings
$lang['settings:site_name'] 					= 'Nome do site';
$lang['settings:site_name_desc'] 				= 'O nome do website para títulos de páginas e para usar por todo o site.';

$lang['settings:site_slogan'] 					= 'Slogan do site';
$lang['settings:site_slogan_desc'] 				= 'O slogan do website para títulos de páginas e para usar por todo o site.';

$lang['settings:site_lang']						= 'Idioma do site';
$lang['settings:site_lang_desc']				= 'O idioma nativo do website, usado para escolher modelos de e-mail para notificações internas e recebimento de contato dos visitantes além de outras funcionalidades que não devem se flexionar ao idioma de um utilizador.';

$lang['settings:contact_email'] 				= 'E-mail de contacto';
$lang['settings:contact_email_desc'] 			= 'Todos os e-mails de utilizadores, visitantes e do site devem ir para este endereço.';

$lang['settings:server_email'] 					= 'Servidor de e-mail';
$lang['settings:server_email_desc'] 			= 'Todos e-mails para utilizadores devem ir para este endereço de e-mail.';

$lang['settings:meta_topic']					= 'Meta tema';
$lang['settings:meta_topic_desc']				= 'Duas ou três palavras descrevendo o tipo de empresa/website.';

$lang['settings:currency'] 						= 'Moeda';
$lang['settings:currency_desc'] 				= 'O símbolo monetário para usar em produtos, serviços, etc.';

$lang['settings:dashboard_rss'] 				= 'RSS Feed do Dashboard';
$lang['settings:dashboard_rss_desc'] 			= 'Link para um feed RSS que deve ser mostrado no dashboard.';

$lang['settings:dashboard_rss_count'] 			= 'Itens RSS do Dashboard';
$lang['settings:dashboard_rss_count_desc'] 		= 'Quantos itens RSS devem ser mostrados no dashboard?';

$lang['settings:date_format'] 					= 'Formato da data';
$lang['settings:date_format_desc'] 				= 'Como devem ser exibidas as datas em todo o site e no painel de controlo? ' .
													'Utilize o <a href="http://php.net/manual/en/function.date.php" target="_black">formato de data</a> PHP - OU - ' .
													'Utilize o formato de <a href="http://php.net/manual/en/function.strftime.php" target="_black">strings formatadas como data</a> do PHP.';

$lang['settings:frontend_enabled'] 				= 'Situação do site';
$lang['settings:frontend_enabled_desc'] 		= 'Use esta opção para definir se a frente do site ficará visível ou não. Últil quando houver a necessidade de desligar o site para manutenção.';

$lang['settings:mail_protocol'] 				= 'Protocolo de e-mail';
$lang['settings:mail_protocol_desc'] 			= 'Seleccione o protocolo de e-mail desejado.';

$lang['settings:mail_sendmail_path'] 			= 'Caminho do Sendmail';
$lang['settings:mail_sendmail_path_desc']		= 'Caminho para o sendmail.';

$lang['settings:mail_smtp_host'] 				= 'Host do SMTP';
$lang['settings:mail_smtp_host_desc'] 			= 'O nome do host do seu servidor SMTP.';

$lang['settings:mail_smtp_pass'] 				= 'Password do SMTP';
$lang['settings:mail_smtp_pass_desc'] 			= 'A password do SMTP.';

$lang['settings:mail_smtp_port'] 				= 'Porta do SMTP';
$lang['settings:mail_smtp_port_desc'] 			= 'O número da porta do SMTP.';

$lang['settings:mail_smtp_user'] 				= 'Utilizador do SMTP';
$lang['settings:mail_smtp_user_desc'] 			= 'O nome de utilizafor do SMTP.';

$lang['settings:unavailable_message']			= 'Mensagem de indisponibilidade';
$lang['settings:unavailable_message_desc'] 		= 'Quando o site for desligado ou houver um problema maior, esta mensagem deverá aparecer para os utilizadores.';

$lang['settings:default_theme'] 				= 'Tema padrão';
$lang['settings:default_theme_desc'] 			= 'Selecione o tema que quer que os utilizadores vejam por padrão.';

$lang['settings:activation_email'] 				= 'E-mail de activação';
$lang['settings:activation_email_desc'] 		= 'Enviar um e-mail com link de activação quando um utilizador se registar. Desactive isto para que apenas administradores activem as contas.';

$lang['settings:records_per_page'] 				= 'Registos por página';
$lang['settings:records_per_page_desc'] 		= 'Quantos registos nos devemos mostrar por página na seccão administrativa?';

$lang['settings:rss_feed_items'] 				= 'Quantidade de itens do Feed';
$lang['settings:rss_feed_items_desc'] 			= 'Quantos itens nos devemos mostrar nos feeds de RSS/novidades?';


$lang['settings:enable_profiles'] 				= 'Activar perfis';
$lang['settings:enable_profiles_desc'] 			= 'Permitir que utilizadores adicionem e editem perfis.';

$lang['settings:ga_email'] 						= 'E-mail do Google Analytic';
$lang['settings:ga_email_desc']					= 'E-mail utilizado para o Google Analytics, é necessário para mostrar o gráfico no dashboard.';

$lang['settings:ga_password'] 					= 'Password do Google Analytic';
$lang['settings:ga_password_desc']				= 'Password do Google Analytics. Isso também é necessária para mostrar o gráfico no dashboard.';

$lang['settings:ga_profile'] 					= 'Perfil do Google Analytic';
$lang['settings:ga_profile_desc']				= 'ID do Perfil para este site no Google Analytics.';

$lang['settings:ga_tracking'] 					= 'Cód. de acompanhamento Google';
$lang['settings:ga_tracking_desc']				= 'Digite o seu código de acompanhamento do Google Analytics para ativar a captura de dados do Google Analytics. Ex.: UA-19483569-6';

$lang['settings:twitter_username'] 				= 'Nome de utilizador';
$lang['settings:twitter_username_desc'] 		= 'Nome de utilizador do Twitter.';

$lang['settings:twitter_feed_count'] 			= 'Contador do Feed';
$lang['settings:twitter_feed_count_desc'] 		= 'Quantos tweets devem ser retornados para o bloco de feed do Twitter?';

$lang['settings:twitter_cache'] 				= 'Tempo de cache';
$lang['settings:twitter_cache_desc'] 			= 'Quantos minutos os seus Tweets devem ser armazenados temporariamente?';

$lang['settings:akismet_api_key'] 				= 'Chave da API do Akismet';
$lang['settings:akismet_api_key_desc'] 			= 'Akismet é um bloqueador de spam da equipa WordPress. Isto mantém spam sobre controle sem forçar que utilizadores façam a confirmação humana de CAPTCHA nos formulários.';

$lang['settings:comment_order'] 				= 'Ordenar comentários';
$lang['settings:comment_order_desc']			= 'A ordem de classificação na qual quer exibir os comentários.';

$lang['settings:enable_comments'] 				= 'Permitir comentários';
$lang['settings:enable_comments_desc']			= 'Permite a escrita de comentários no site';

$lang['settings:moderate_comments'] 			= 'Moderar comentários';
$lang['settings:moderate_comments_desc']		= 'Forçar todos os comentários a serem aprovados antes que apareçam no site.';

$lang['settings:comment_markdown']				= 'Permitir Markdown';
$lang['settings:comment_markdown_desc']			= 'Quer permitir que os visitantes possão inserir comentários com Markdown?';

$lang['settings:version'] 						= 'Versão';
$lang['settings:version_desc'] 					= '';

$lang['settings:site_public_lang']				= 'Idiomas públicos';
$lang['settings:site_public_lang_desc']			= 'Quais são as línguas realmente suportadas e oferecidas no front-end do seu site?';

$lang['settings:admin_force_https']				= 'Forçar HTTPS para o Painel de Controlo?';
$lang['settings:admin_force_https_desc']		= 'Permitir apenas HTTPS protocol quando usa o Painel de Controlo?';

$lang['settings:files_cache']					= 'Cache Ficheiros';
$lang['settings:files_cache_desc']				= 'Quando a saída de uma imagem através de site.com/files, devemos definir a expiração de cache para?';

$lang['settings:auto_username']					= 'Auto Username';
$lang['settings:auto_username_desc']			= 'Cria o utilizador automaticamente, ou seja, os utilizadores podem ignonar isto ao fazer o registo.';

$lang['settings:registered_email']				= 'Email de registo de Utilizador';
$lang['settings:registered_email_desc']			= 'Enviar um e-mail de notificação para o contacto de e-mail quando alguém se regista.';

$lang['settings:ckeditor_config']               = 'Config CKEditor';
$lang['settings:ckeditor_config_desc']          = 'Pode encontrar uma lista de itens de configuração válidos em <a target="_blank" href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html">CKEditor\'s documentação</a>.';

$lang['settings:enable_registration']           = 'Habilitar o registro de utilizadores';
$lang['settings:enable_registration_desc']      = 'Permitir que os utilizadores se registem no seu site.';

$lang['settings:profile_visibility']            = 'Profile Visibility'; #translate
$lang['settings:profile_visibility_desc']       = 'Specify who can view user profiles on the public site'; #translate

$lang['settings:cdn_domain']                    = 'CDN Domain';
$lang['settings:cdn_domain_desc']               = 'CDN domínios permite descarregar conteúdos estáticos para servidores de borda diferentes, como, Amazon CloudFront ou MaxCDN.';

#section titles
$lang['settings:section_general']				= 'Geral';
$lang['settings:section_integration']			= 'Integração';
$lang['settings:section_comments']				= 'Comentários';
$lang['settings:section_users']					= 'Utilizadores';
$lang['settings:section_statistics']			= 'Estatísticas';
$lang['settings:section_twitter']				= 'Twitter';
$lang['settings:section_files']					= 'Ficheiros';

#checkbox and radio options
$lang['settings:form_option_Open']				= 'Aberto';
$lang['settings:form_option_Closed']			= 'Fechado';
$lang['settings:form_option_Enabled']			= 'Activo';
$lang['settings:form_option_Disabled']			= 'Desactivado';
$lang['settings:form_option_Required']			= 'Obrigatório';
$lang['settings:form_option_Optional']			= 'Opcional';
$lang['settings:form_option_Oldest First']		= 'Antigos primeiro';
$lang['settings:form_option_Newest First']		= 'Novos primeiro';
$lang['settings:form_option_Text Only']			= 'Apenas Texto';
$lang['settings:form_option_Allow Markdown']	= 'Permitir Markdown';
$lang['settings:form_option_Yes']				= 'Sim'; 
$lang['settings:form_option_No']				= 'Não';


// messages
$lang['settings:no_settings']					= 'Atualmente não existem definições.';
$lang['settings:save_success']					= 'As suas configurações foram salvas!';

/* End of file settings_lang.php */
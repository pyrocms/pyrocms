<?php defined('BASEPATH') OR exit('No direct script access allowed');

#section settings
$lang['settings:site_name']						= 'Nombre del Sitio';
$lang['settings:site_name_desc']				= 'El nombre del sitio web para los títulos de página y para su uso dentro del sitio.';

$lang['settings:site_slogan']					= 'Lema del Sitio';
$lang['settings:site_slogan_desc']				= 'Lema para los títulos de página y para su uso dentro del sitio.';

$lang['settings:site_lang']						= 'Idioma del sitio';
$lang['settings:site_lang_desc']				= 'Idioma nativo del sitio, usado para escoger plantillas de correos para correos de notificaciones internas, recibir detalles de tus visitantes y otras características que no deberían influír con el idioma del visitante.';

$lang['settings:contact_email']					= 'E-mail de contacto';
$lang['settings:contact_email_desc']			= 'Todos los e-mails de los usuarios e invitados se dirigirán a esta dirección de e-mail.';

$lang['settings:server_email']					= 'E-mail del Servidor';
$lang['settings:server_email_desc']				= 'Todos los e-mails a los usuarios saldrán de esta dirección de e-mail.';

$lang['settings:meta_topic']					= 'Meta Tópico';
$lang['settings:meta_topic_desc']				= 'Dos o tres palabras describiendo este tipo de compañía/sitio web.';

$lang['settings:currency']						= 'Moneda';
$lang['settings:currency_desc']					= 'Símbolo de moneda para uso en productos, servicios, etc.';

$lang['settings:dashboard_rss']					= 'Feed RSS del Tablero';
$lang['settings:dashboard_rss_desc']			= 'Enlace al feed RSS que será mostrado en el tablero.';

$lang['settings:dashboard_rss_count']			= 'Número de items RSS del Tablero';
$lang['settings:dashboard_rss_count_desc']		= 'Cantidad de items que se mostrarán en el tablero.';

$lang['settings:date_format'] 					= 'Formato de la Fecha';
$lang['settings:date_format_desc']				= '¿Como deberían ser presentadas las fechas en el sitio web y panel de control? ' .
													'Usando <a href="http://php.net/manual/es/function.date.php" target="_black">formato de fecha</a> de PHP - OR - ' .
													'Usando el formato de <a href="http://php.net/manual/es/function.strftime.php" target="_black">cadenas formateadas como fechas</a> desde PHP.';

$lang['settings:frontend_enabled']				= 'Estado del Sitio';
$lang['settings:frontend_enabled_desc']			= 'Usa esta opción para habilitar o desabilitar el sitio visible al usuario. Útil cuando quieres poner el sitio en mantenimiento.';

$lang['settings:mail_protocol'] 				= 'Protocolo de correo';
$lang['settings:mail_protocol_desc'] 			= 'Seleccione el protocolo de correo deseado.';

$lang['settings:mail_sendmail_path'] 			= 'Ruta a Sendmail';
$lang['settings:mail_sendmail_path_desc']		= 'Ruta al binario del servidor sendmail.';

$lang['settings:mail_smtp_host'] 				= 'SMTP Host';
$lang['settings:mail_smtp_host_desc'] 			= 'El nombre del host de tu servidor smpt.';

$lang['settings:mail_smtp_pass'] 				= 'Contraseña SMTP';
$lang['settings:mail_smtp_pass_desc'] 			= 'Contraseña para tu servidor SMTP.';

$lang['settings:mail_smtp_port'] 				= 'Puerto SMTP';
$lang['settings:mail_smtp_port_desc'] 			= 'El puerto usado por tu servidor SMTP.';

$lang['settings:mail_smtp_user'] 				= 'Nombre de usuario SMTP';
$lang['settings:mail_smtp_user_desc'] 			= 'El nombre de usuario de tu servidor SMTP.';

$lang['settings:unavailable_message']			= 'Mensaje de Disponibilidad';
$lang['settings:unavailable_message_desc']		= 'Cuando el sitio esta fuera de línea por un problema mayor, este mensaje será mostrado a los usuarios.';

$lang['settings:default_theme']					= 'Tema Predeterminado';
$lang['settings:default_theme_desc']			= 'Elija el tema predeterminado que verán los usuarios por default.';

$lang['settings:activation_email']				= 'E-mail de Activación';
$lang['settings:activation_email_desc']			= 'Enviar un e-mail con un enlace de activación cuando un usuario crea una cuenta en el sitio. Desactivar para permitir sólo a los administradores crear cuentas.';

$lang['settings:records_per_page']				= 'Registros por página';
$lang['settings:records_per_page_desc']			= 'Número de registros a ser mostrados en la sección de administración.';

$lang['settings:rss_feed_items']				= 'Número de items RSS';
$lang['settings:rss_feed_items_desc']			= 'Cantidad de items que se mostrarán en los feeds RSS';


$lang['settings:enable_profiles']				= 'Habilitar Perfiles';
$lang['settings:enable_profiles_desc']			= 'Permitir a los usuarios editar sus perfiles.';

$lang['settings:ga_email'] 						= 'Correo Electrónico de Google Analytic';
$lang['settings:ga_email_desc']					= 'Correo electrónico usado por Google Analytics, necesitamos esto para mostrar el gráfico en el tablero.';

$lang['settings:ga_password'] 					= 'Contraseña de Google Analytic';
$lang['settings:ga_password_desc']				= 'Contraseña de Google Analytic. Esto también es necesario para mostrar el gráfico en el tablero.';

$lang['settings:ga_profile'] 					= 'Perfil de Google Analytic';
$lang['settings:ga_profile_desc']				= 'ID del perfil para este sitio web en Google Analytics.';

$lang['settings:ga_tracking'] 					= 'Código de seguimiento de Google';
$lang['settings:ga_tracking_desc']				= 'Inserte su código de seguimiento de Google para permitir que Google Analytics capture los datos. E.g: UA-19483569-6';

$lang['settings:akismet_api_key']				= 'Clave de Akismet';
$lang['settings:akismet_api_key_desc']			= 'Akismet es un bloqueador de spam del equipo de Wordpress. Mantiene el spam bajo control forzando a los usuarios a rellenar CAPTCHAS.';

$lang['settings:comment_order'] 				= 'Orden de los comentarios';
$lang['settings:comment_order_desc']			= 'Criterio para ordenar los comentarios.';

$lang['settings:moderate_comments']				= 'Moderar Comentarios';
$lang['settings:moderate_comments_desc']		= 'Forzar comentarios a ser aprobados antes de mostrarse en el sitio.';

$lang['settings:version']						= 'Versión';
$lang['settings:version_desc']					= '';

$lang['settings:ckeditor_config']               = 'CKEditor Config'; #translate
$lang['settings:ckeditor_config_desc']          = 'You can find a list of valid configuration items in <a target="_blank" href="http://docs.cksource.com/ckeditor_api/symbols/CKEDITOR.config.html">CKEditor\'s documentation.</a>'; #translate

$lang['settings:enable_registration']           = 'Enable user registration'; #translate
$lang['settings:enable_registration_desc']      = 'Allow users to register in your site.'; #translate

$lang['settings:profile_visibility']            = 'Profile Visibility'; #translate
$lang['settings:profile_visibility_desc']       = 'Specify who can view user profiles on the public site'; #translate

$lang['settings:cdn_domain']                    = 'CDN Domain'; #translate
$lang['settings:cdn_domain_desc']               = 'CDN domains allow you to offload static content to various edge servers, like Amazon CloudFront or MaxCDN.'; #translate

#section titles
$lang['settings:section_general']				= 'General';
$lang['settings:section_integration']			= 'Integración';
$lang['settings:section_comments']				= 'Comentarios';
$lang['settings:section_users']					= 'Usuarios';
$lang['settings:section_statistics']			= 'Estadísticas';

#checkbox and radio options
$lang['settings:form_option_Open']				= 'Abierto';
$lang['settings:form_option_Closed']			= 'Cerrado';
$lang['settings:form_option_Enabled']			= 'Activado';
$lang['settings:form_option_Disabled']			= 'Desactivado';
$lang['settings:form_option_Required']			= 'Requerido';
$lang['settings:form_option_Optional']			= 'Opcional';
$lang['settings:form_option_Oldest First']		= 'Antiguos Primero';
$lang['settings:form_option_Newest First']		= 'Nuevos Primero';

// titles
$lang['settings:edit_title']					= 'Editar configuraciones';

// messages
$lang['settings:no_settings']					= 'There are currently no settings.'; #translate
$lang['settings:save_success']					= 'Tu configuración ha sido guardada.';

/* End of file settings_lang.php */
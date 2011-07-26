<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['settings_save_success']					= 'Tu configuración ha sido guardada.';
$lang['settings_edit_title']					= 'Editar configuraciones';

#section settings
$lang['settings_site_name']						= 'Nombre del Sitio';
$lang['settings_site_name_desc']				= 'El nombre del sitio web para los títulos de página y para su uso dentro del sitio.';

$lang['settings_site_slogan']					= 'Lema del Sitio';
$lang['settings_site_slogan_desc']				= 'Lema para los títulos de página y para su uso dentro del sitio.';

$lang['settings_site_lang']						= 'Idioma del sitio';
$lang['settings_site_lang_desc']				= 'Idioma nativo del sitio, usado para escoger plantillas de correos para correos de notificaciones internas, recibir detalles de tus visitantes y otras características que no deberían influír con el idioma del visitante.';

$lang['settings_contact_email']					= 'E-mail de contacto';
$lang['settings_contact_email_desc']			= 'Todos los e-mails de los usuarios e invitados se dirigirán a esta dirección de e-mail.';

$lang['settings_server_email']					= 'E-mail del Servidor';
$lang['settings_server_email_desc']				= 'Todos los e-mails a los usuarios saldrán de esta dirección de e-mail.';

$lang['settings_meta_topic']					= 'Meta Tópico';
$lang['settings_meta_topic_desc']				= 'Dos o tres palabras describiendo este tipo de compañía/sitio web.';

$lang['settings_currency']						= 'Moneda';
$lang['settings_currency_desc']					= 'Símbolo de moneda para uso en productos, servicios, etc.';

$lang['settings_dashboard_rss']					= 'Feed RSS del Tablero';
$lang['settings_dashboard_rss_desc']			= 'Enlace al feed RSS que será mostrado en el tablero.';

$lang['settings_dashboard_rss_count']			= 'Número de items RSS del Tablero';
$lang['settings_dashboard_rss_count_desc']		= 'Cantidad de items que se mostrarán en el tablero.';

$lang['settings_date_format'] 					= 'Formato de la Fecha';
$lang['settings_date_format_desc']				= '¿Como deberían ser presentadas las fechas en el sitio web y panel de control? ' .
													'Usando <a href="http://php.net/manual/es/function.date.php" target="_black">formato de fecha</a> de PHP - OR - ' .
													'Usando el formato de <a href="http://php.net/manual/es/function.strftime.php" target="_black">cadenas formateadas como fechas</a> desde PHP.';

$lang['settings_frontend_enabled']				= 'Estado del Sitio';
$lang['settings_frontend_enabled_desc']			= 'Usa esta opción para habilitar o desabilitar el sitio visible al usuario. Útil cuando quieres poner el sitio en mantenimiento.';

$lang['settings_mail_protocol'] 				= 'Protocolo de correo';
$lang['settings_mail_protocol_desc'] 			= 'Seleccione el protocolo de correo deseado.';

$lang['settings_mail_sendmail_path'] 			= 'Ruta a Sendmail';
$lang['settings_mail_sendmail_path_desc']		= 'Ruta al binario del servidor sendmail.';

$lang['settings_mail_smtp_host'] 				= 'SMTP Host';
$lang['settings_mail_smtp_host_desc'] 			= 'El nombre del host de tu servidor smpt.';

$lang['settings_mail_smtp_pass'] 				= 'Contraseña SMTP';
$lang['settings_mail_smtp_pass_desc'] 			= 'Contraseña para tu servidor SMTP.';

$lang['settings_mail_smtp_port'] 				= 'Puerto SMTP';
$lang['settings_mail_smtp_port_desc'] 			= 'El puerto usado por tu servidor SMTP.';

$lang['settings_mail_smtp_user'] 				= 'Nombre de usuario SMTP';
$lang['settings_mail_smtp_user_desc'] 			= 'El nombre de usuario de tu servidor SMTP.';

$lang['settings_unavailable_message']			= 'Mensaje de Disponibilidad';
$lang['settings_unavailable_message_desc']		= 'Cuando el sitio esta fuera de línea por un problema mayor, este mensaje será mostrado a los usuarios.';

$lang['settings_default_theme']					= 'Tema Predeterminado';
$lang['settings_default_theme_desc']			= 'Elija el tema predeterminado que verán los usuarios por default.';

$lang['settings_activation_email']				= 'E-mail de Activación';
$lang['settings_activation_email_desc']			= 'Enviar un e-mail con un enlace de activación cuando un usuario crea una cuenta en el sitio. Desactivar para permitir sólo a los administradores crear cuentas.';

$lang['settings_records_per_page']				= 'Registros por página';
$lang['settings_records_per_page_desc']			= 'Número de registros a ser mostrados en la sección de administración.';

$lang['settings_rss_feed_items']				= 'Número de items RSS';
$lang['settings_rss_feed_items_desc']			= 'Cantidad de items que se mostrarán en los feeds RSS';

$lang['settings_require_lastname']				= 'Requerir Apellido';
$lang['settings_require_lastname_desc'] 		= 'Para algunas situaciones es requerido el apellido. Marque esta casilla si deseas forzar el ingreso del apellido.';

$lang['settings_enable_profiles']				= 'Habilitar Perfiles';
$lang['settings_enable_profiles_desc']			= 'Permitir a los usuarios editar sus perfiles.';

$lang['settings_ga_email'] 						= 'Correo Electrónico de Google Analytic';
$lang['settings_ga_email_desc']					= 'Correo electrónico usado por Google Analytics, necesitamos esto para mostrar el gráfico en el tablero.';

$lang['settings_ga_password'] 					= 'Contraseña de Google Analytic';
$lang['settings_ga_password_desc']				= 'Contraseña de Google Analytic. Esto también es necesario para mostrar el gráfico en el tablero.';

$lang['settings_ga_profile'] 					= 'Perfil de Google Analytic';
$lang['settings_ga_profile_desc']				= 'ID del perfil para este sitio web en Google Analytics.';

$lang['settings_ga_tracking'] 					= 'Código de seguimiento de Google';
$lang['settings_ga_tracking_desc']				= 'Inserte su código de seguimiento de Google para permitir que Google Analytics capture los datos. E.g: UA-19483569-6';

$lang['settings_twitter_username']				= 'Usuario';
$lang['settings_twitter_username_desc']			= 'Usuario de Twitter.';

$lang['settings_twitter_consumer_key']			= 'Consumer Key';
$lang['settings_twitter_consumer_key_desc']		= 'Consumer key de Twitter.';

$lang['settings_twitter_consumer_key_secret']	= 'Consumer Key Secret';
$lang['settings_twitter_consumer_key_secret_desc'] = 'Consumer key secret de Twitter.';

$lang['settings_twitter_blog']					= 'Integración con Twitter';
$lang['settings_twitter_blog_desc']				= '¿Te gustaría publicar enlaces a los artículos publicados en Twitter?';

$lang['settings_twitter_feed_count']			= 'Cantidad de Tweets';
$lang['settings_twitter_feed_count_desc']		= 'Cantidad de tweets que seran mostrados en el bloque de twitter.';

$lang['settings_twitter_cache']					= 'Tiempo de Cache';
$lang['settings_twitter_cache_desc']			= 'Tiempo en minutos que serán almacenados los tweets temporarlmente.';

$lang['settings_akismet_api_key']				= 'Clave de Akismet';
$lang['settings_akismet_api_key_desc']			= 'Akismet es un bloqueador de spam del equipo de Wordpress. Mantiene el spam bajo control forzando a los usuarios a rellenar CAPTCHAS.';

$lang['settings_comment_order'] 				= 'Orden de los comentarios';
$lang['settings_comment_order_desc']			= 'Criterio para ordenar los comentarios.';

$lang['settings_moderate_comments']				= 'Moderar Comentarios';
$lang['settings_moderate_comments_desc']		= 'Forzar comentarios a ser aprobados antes de mostrarse en el sitio.';

$lang['settings_version']						= 'Versión';
$lang['settings_version_desc']					= '';

#section titles
$lang['settings_section_general']				= 'General';
$lang['settings_section_integration']			= 'Integración';
$lang['settings_section_comments']				= 'Comentarios';
$lang['settings_section_users']					= 'Usuarios';
$lang['settings_section_statistics']			= 'Estadísticas';
$lang['settings_section_twitter']				= 'Twitter';

#checkbox and radio options
$lang['settings_form_option_Open']				= 'Abierto';
$lang['settings_form_option_Closed']			= 'Cerrado';
$lang['settings_form_option_Enabled']			= 'Activado';
$lang['settings_form_option_Disabled']			= 'Desactivado';
$lang['settings_form_option_Required']			= 'Requerido';
$lang['settings_form_option_Optional']			= 'Opcional';
$lang['settings_form_option_Oldest First']		= 'Antiguos Primero';
$lang['settings_form_option_Newest First']		= 'Nuevos Primero';

/* End of file settings_lang.php */
/* Location: ./system/cms/modules/settings/language/spanish/settings_lang.php */

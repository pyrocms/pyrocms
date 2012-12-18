<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['user:add_field']                        	= 'Add User Profile Field'; #translate
$lang['user:profile_delete_success']           	= 'User profile field deleted successfully'; #translate
$lang['user:profile_delete_failure']            = 'There was a problem with deleting your user profile field'; #translate
$lang['profile_user_basic_data_label']  		= 'Basic Data'; #translate
$lang['profile_company']         	  			= 'Company'; #translate
$lang['profile_updated_on']           			= 'Updated On'; #translate
$lang['user:profile_fields_label']	 		 	= 'Profile Fields'; #translate`

$lang['user:register_header']				= 'Registro';
$lang['user:register_step1']				= '<strong>Paso 1:</strong> Registro';
$lang['user:register_step2']				= '<strong>Paso 2:</strong> Activación';

$lang['user:login_header']					= 'Login';

# titles
$lang['user:add_title']						= 'Crear usuario';
$lang['user:list_title'] 					= 'Lista de usuarios';
$lang['user:inactive_title']				= 'Usuarios inactivos';
$lang['user:active_title']					= 'Usuarios activos';
$lang['user:registred_title']				= 'Usuarios registrados';

# labels
$lang['user:edit_title']					= 'Editar usuario "%s"';
$lang['user:details_label']					= 'Detalles';
$lang['user:first_name_label']				= 'Nombre';
$lang['user:last_name_label']				= 'Apellido';
$lang['user:group_label']					= 'Grupo';
$lang['user:activate_label'] 				= 'Activar';
$lang['user:password_label'] 				= 'Contraseña';
$lang['user:password_confirm_label']		= 'Confirmar contraseña';
$lang['user:name_label']					= 'Nombre';
$lang['user:joined_label']					= 'Fecha de creación';
$lang['user:last_visit_label']				= 'Última visita';
$lang['user:never_label']					= 'Nunca';

$lang['user:no_inactives']					= 'No hay usuarios inactivos.';
$lang['user:no_registred']					= 'No hay usuarios registrados.';
$lang['account_changes_saved']				= 'Los cambios a tu cuenta han sido grabados exitosamente.';
$lang['indicates_required'] 				= 'Indica campos necesarios';

# Registration / Activation / Reset Password

$lang['user:send_activation_email']            = 'Send Activation Email'; #translate
$lang['user:do_not_activate']                  = 'Inactive'; #translate
$lang['user:register_title']				= 'Registrar';
$lang['user:activate_account_title']		= 'Activar cuenta';
$lang['user:activate_label']				= 'Activar';
$lang['user:activated_account_title']		= 'Cuenta activada';
$lang['user:reset_password_title']			= 'Reestablecer contraseña';
$lang['user:password_reset_title']			= 'Reestablecer contraseña';


$lang['user:error_username']				= 'El usuario que ingresaste ya se encuentra en uso';
$lang['user:error_email']					= 'El email que ingresaste ya se encuentra en uso';

$lang['user:full_name']						= 'Nombre completo';
$lang['user:first_name']					= 'Nombre';
$lang['user:last_name']						= 'Apellido';
$lang['user:username']						= 'Usuario';
$lang['user:display_name']					= 'Nombre público';
$lang['user:email_use'] 					   = 'used to login'; #translate
$lang['user:remember']						= 'Recordarme';
$lang['user:group_id_label']				= 'ID de Grupo';

$lang['user:level']							= 'Rol de usuario';
$lang['user:active']						= 'Activar';
$lang['user:lang']							= 'Idioma';

$lang['user:activation_code']				= 'Código de activación';

$lang['user:reset_instructions']			   = 'Enter your email address or username'; #translate
$lang['user:reset_password_link']			= 'Olvidaste tu contraseña?';

$lang['user:activation_code_sent_notice']	= 'Se te ha enviado un e-mail con tu código de activación.';
$lang['user:activation_by_admin_notice']	= 'Tu registro esta esperando la aprobación de un administrador.';
$lang['user:registration_disabled']         = 'Lo sentimos, pero el registro de usuarios está deshabilitado.';

# Settings

$lang['user:details_section']				= 'Nombre';
$lang['user:password_section']				= 'Cambiar contraseña';
$lang['user:other_settings_section'] 		= 'Otras configuraciones';

$lang['user:settings_saved_success']		= 'La configuración para tu cuenta han sido grabadas.';
$lang['user:settings_saved_error']			= 'Ha ocurrido un error.';

# Buttons

$lang['user:register_btn']					= 'Registrar';
$lang['user:activate_btn']					= 'Activar';
$lang['user:reset_pass_btn']				= 'Reestablecer contraseña';
$lang['user:login_btn']						= 'Login';
$lang['user:settings_btn']					= 'Actualizar configuración';

## Errors & Messages

# Create
$lang['user:added_and_activated_success'] 	= 'El nuevo usuario ha sido creado y activado.';
$lang['user:added_not_activated_success'] 	= 'El nuevo usuario ha sido creado, la cuenta necesita ser activada.';

# Edit
$lang['user:edit_user_not_found_error'] 	= 'No se ha encontrado el usuario.';
$lang['user:edit_success'] 					= 'Usuario actualizado exitosamente.';
$lang['user:edit_error'] 					= 'Ha ocurrido un error al tratar de actualizar el usuario.';

# Activate
$lang['user:activate_success'] 				= '%s usuarios de %s han sido activados.';
$lang['user:activate_error'] 				= 'Necesitas seleccionar algunos usuarios primero.';

# Delete
$lang['user:delete_self_error'] 			= 'No puedes borrarte a ti mismo!';
$lang['user:mass_delete_success'] 			= '%s usuarios de %s han sido borrados.';
$lang['user:mass_delete_error'] 			= 'Necesitas seleccionar algunos usuarios primero.';

# Register
$lang['user:email_pass_missing'] 			= 'Campos del Email o contraseña no estan completos.';
$lang['user:email_exists'] 					= 'El correo electrónico que has escogido esta siendo utilizado por otro usuario.';
$lang['user:register_error']				   = 'We think you are a bot. If we are mistaken please accept our apologies.'; #translate
$lang['user:register_reasons'] 				= 'Registrate para acceder a áreas especiales que normalmente están restringidas. Esto quiere decir que tu configuración será recordada, más contenido y menos publicidad.';

# Activation
$lang['user:activation_incorrect']   		= 'Activación fallida. Por favor, revisa tus detalles y asegúrate que el BLOQ MAYUS no está activado.';
$lang['user:activated_message']   			= 'Tu cuenta ha sido activada, ahora puedes ingresar con tu cuenta.';

# Login
$lang['user:logged_in']						= 'Usted se ha conectado satisfactoriamente.';
$lang['user:already_logged_in'] 			= 'Ya te encuentras logueado. Por favor, sal de tu cuente antes de tratar nuevamente.';
$lang['user:login_incorrect'] 				= 'E-mail o contraseña no coinciden. Por favor, revisa tus detalles y asegúrate que el BLOQ MAYUS no está activado.';
$lang['user:inactive']   					= 'La cuenta a la que tratas de acceder se encuentra inactiva.<br />Revisa tu e-mail para instrucciones de como activar tu cuenta - <em>puede estar en tu correo no deseado</em>.';

# Logged Out
$lang['user:logged_out']   					= 'Has salido de tu cuenta.';

# Forgot Pass
$lang['user:forgot_incorrect']   			= "No se han encontrado cuentas con estos detalles.";

$lang['user:password_reset_message']   		= "Tu contraseña ha sido reestablecida. Deberías recibir un correo dentro de las próximas 2 horas. Si no lo recibes, puede que se haya recibido en tu correo no deseado por accidente.";

# Emails

# Activation
$lang['user:activation_email_subject'] 		= 'Activación necesaria.';
$lang['user:activation_email_body'] 		= 'Gracias por activar tu cuenta con %s. Para entrar con tu cuenta en el sitio, por favor sigue el vínculo debajo:';


$lang['user:activated_email_subject'] 		= 'Activación completada';
$lang['user:activated_email_content_line1'] = 'Gracias por registrarte en %s. Antes de que podamos activar tu cuenta, por favor completa el procedimiento de activación haciendo click en el link siguiente:';
$lang['user:activated_email_content_line2'] = 'En caso que no puedas ingresar haciendo click sobre el link, copia la dirección en tu explorador y utiliza el siguiente código de activación:';

# Reset Pass
$lang['user:reset_pass_email_subject'] 		= 'Contraseña reestablecida';
$lang['user:reset_pass_email_body'] 		= 'Tu contraseña en %s ha sido reestablecido. Si no pediste este cambio, por favor escribe a %s y resolveremos esta situación por ti.';

// Profile
$lang['profile_of_title']				= 'Perfil de %s';

$lang['profile_user_details_label']		= 'Detalles de usuario';
$lang['profile_role_label']				= 'Rol';
$lang['profile_registred_on_label']		= 'Registrado el';
$lang['profile_last_login_label']		= 'Últimmo login';
$lang['profile_male_label']				= 'Masculino';
$lang['profile_female_label']			= 'Femenino';

$lang['profile_not_set_up']				= 'Este usuario no tiene un perfil ajustado.';

$lang['profile_edit']					= 'Editar tu perfil';

$lang['profile_personal_section']		= 'Personal';

$lang['profile_display_name']			= 'Nombre a mostrar';
$lang['profile_dob']					= 'Fecha de nacimiento';
$lang['profile_dob_day']				= 'Día';
$lang['profile_dob_month']				= 'Mes';
$lang['profile_dob_year']				= 'Año';
$lang['profile_gender']					= 'Sexo';
$lang['profile_gender_nt']            = 'Not Telling'; #translate
$lang['profile_gender_male']          = 'Male'; #translate
$lang['profile_gender_female']        = 'Female'; #translate
$lang['profile_bio']					= 'Sobre mi';

$lang['profile_contact_section']		= 'Contacto';

$lang['profile_phone']					= 'Teléfono';
$lang['profile_mobile']					= 'Móvil / Celular';
$lang['profile_address']				= 'Dirección';
$lang['profile_address_line1']			= 'Línea #1';
$lang['profile_address_line2']			= 'Línea #2';
$lang['profile_address_line3']			= 'Línea #3';
$lang['profile_address_postcode']		= 'Código postal';
$lang['profile_website']				= 'Sitio web';

$lang['profile_messenger_section']		= 'Mensajería instantánea';

$lang['profile_msn_handle']				= 'MSN';
$lang['profile_aim_handle']				= 'AIM';
$lang['profile_yim_handle']				= 'Yahoo! messenger';
$lang['profile_gtalk_handle']			= 'GTalk';

$lang['profile_avatar_section']			= 'Avatar';
$lang['profile_social_section']			= 'Social';

$lang['profile_gravatar']				= 'Gravatar';
$lang['profile_twitter']				= 'Twitter';

$lang['profile_edit_success']			= 'Tu perfil ha sido actualizado.';
$lang['profile_edit_error']				= 'Ha ocurrido un error.';

// -- Buttons ------------------------------------------------------------------------------------------------

$lang['profile_save_btn']				= 'Guardar perfil';

/* End of file user_lang.php */
<?php defined('BASEPATH') or exit('No direct script access allowed');

/* Messages */

$lang['streams:save_field_error'] 						= "Hubo un problema al salvar este campo.";
$lang['streams:field_add_success']						= "Campo añadido exitósamente.";
$lang['streams:field_update_error']						= "Hubo un problema al actualizar este campo.";
$lang['streams:field_update_success']					= "Campo actualizado exitósamente.";
$lang['streams:field_delete_error']						= "Hubo un problema al eliminar este campo.";
$lang['streams:field_delete_success']					= "Campo eliminado exitósamente.";
$lang['streams:view_options_update_error']				= "Hubo un problema al actualizar las opciones de vista.";
$lang['streams:view_options_update_success']			= "Opciones de vista actualizadas exitósamente.";
$lang['streams:remove_field_error']						= "Hubo un problema al remover este campo.";
$lang['streams:remove_field_success']					= "Campo removido exitósamente.";
$lang['streams:create_stream_error']					= "Hubo un problema al crear este stream.";
$lang['streams:create_stream_success']					= "Stream creado exitósamente.";
$lang['streams:stream_update_error']					= "Hubo un problema al actualizar este stream.";
$lang['streams:stream_update_success']					= "Stream actualizado exitósamente.";
$lang['streams:stream_delete_error']					= "Hubo un problema al eliminar este stream.";
$lang['streams:stream_delete_success']					= "Stream eliminado exitósamente.";
$lang['streams:stream_field_ass_add_error']				= "Hubo un problema al agregar el campo a este stream.";
$lang['streams:stream_field_ass_add_success']			= "Campo añadido al stream exitósamente.";
$lang['streams:stream_field_ass_upd_error']				= "Hubo un problema al actualizar esta asignación de campo.";
$lang['streams:stream_field_ass_upd_success']			= "Asignación de campo actualizada exitósamente.";
$lang['streams:delete_entry_error']						= "Hubo un problema al eliminar esta entrada.";
$lang['streams:delete_entry_success']					= "Entrada eliminada exitósamente.";
$lang['streams:new_entry_error']						= "Hubo un problema al añadir esta entrada."; // @done
$lang['streams:new_entry_success']						= "Entrada añadida exitósamente."; // @done
$lang['streams:edit_entry_error']						= "Hubo un problema al actualizar esta entrada."; // @done
$lang['streams:edit_entry_success']					= "Entrada actualizada exitósamente."; // @done
$lang['streams:delete_summary']							= "¿Estás seguro de que quieres eliminar el stream <strong>%s</strong>? Esto <strong>eliminará %s %s</strong> permanentemente.";

/* Misc Errors */

$lang['streams:no_stream_provided']						= "No se ha provisto un stream."; // @done
$lang['streams:invalid_stream']							= "Stream inválido."; // @done
$lang['streams:not_valid_stream']						= "no es un stream válido."; // @done
$lang['streams:invalid_stream_id']						= "Stream ID inválido."; // @done
$lang['streams:invalid_row']							= "Fila inválida."; // @done
$lang['streams:invalid_id']								= "ID inválido."; // @done
$lang['streams:cannot_find_assign']						= "No se encuentra campo asignado."; // @done
$lang['streams:cannot_find_pyrostreams']				= "No se encuentra PyroStreams."; // @done
$lang['streams:table_exists']							= "Una tabla con slug %s ya existe."; // @done
$lang['streams:no_results']								= "No hay resultados"; // @done
$lang['streams:no_entry']								= "No se encuentra entrada."; // @done
$lang['streams:invalid_search_type']					= "no es tipo de búsqueda válida."; // @done
$lang['streams:search_not_found']						= "No se encuentra búsqueda."; // @done

/* Validation Messages */

$lang['streams:field_slug_not_unique']					= "Este slug de campo ya esta utilizado.";
$lang['streams:not_mysql_safe_word']					= "El campo %s es una palabra reservada para MySQL.";
$lang['streams:not_mysql_safe_characters']				= "El campo %s contiene caracteres no permitidos.";
$lang['streams:type_not_valid']							= "Por favor seleccione un tipo de campo válido.";
$lang['streams:stream_slug_not_unique']					= "Este slug de stream ya esta utilizado.";
$lang['streams:field_unique']							= "El campo %s tiene que ser único."; // @done
$lang['streams:field_is_required']						= "El campo %s es requerido."; // @done
$lang['streams:date_out_or_range']						= "The date you have chosen is out of the acceptable range."; #translate

/* Field Labels */

$lang['streams:label.field']							= "Campo";
$lang['streams:label.field_required']					= "Campo Requerido";
$lang['streams:label.field_unique']						= "Campo Único";
$lang['streams:label.field_instructions']				= "Instrucciones del Campo";
$lang['streams:label.make_field_title_column']			= "Establecer campo como Columna de Título";
$lang['streams:label.field_name']						= "Nombre del Campo";
$lang['streams:label.field_slug']						= "Slug del Campo";
$lang['streams:label.field_type']						= "Tipo de Campo";
$lang['streams:id']										= "ID";
$lang['streams:created_by']								= "Creado Por"; // @done
$lang['streams:created_date']							= "Fecha Creado";
$lang['streams:updated_date']							= "Fecha Actualizado";
$lang['streams:value']									= "Valor";
$lang['streams:manage']									= "Administrar";
$lang['streams:search']									= "Búsqueda"; // @done
$lang['streams:stream_prefix']							= "Stream Prefix"; #translate

/* Field Instructions */

$lang['streams:instr.field_instructions']				= "Presentado en el formulario al entrar o editar datos.";
$lang['streams:instr.stream_full_name']					= "Nombre completo para el stream.";
$lang['streams:instr.slug']								= "Minúsculas, solo letras y underscores.";

/* Titles */

$lang['streams:assign_field']							= "Asigna Campo al Stream";
$lang['streams:edit_assign']							= "Editar Asignación";
$lang['streams:add_field']								= "Crear Campo";
$lang['streams:edit_field']								= "Editar Campo";
$lang['streams:fields']									= "Campos";
$lang['streams:streams']								= "Streams";
$lang['streams:list_fields']							= "Lista de Campos";
$lang['streams:new_entry']								= "Nueva Entrada";
$lang['streams:stream_entries']							= "Entradas al Stream";
$lang['streams:entries']								= "Entradas"; // @done
$lang['streams:stream_admin']							= "Administrar Stream";
$lang['streams:list_streams']							= "Lista de Streams";
$lang['streams:sure']									= "¿Está seguro?";
$lang['streams:field_assignments']						= "Asignaciones de Campo";
$lang['streams:new_field_assign']						= "Nueva Asignación de Campo";
$lang['streams:stream_name']							= "Nombre del Stream";
$lang['streams:stream_slug']							= "Stream Slug";
$lang['streams:about']									= "Acerca de";
$lang['streams:total_entries']							= "Total de Entradas";
$lang['streams:add_stream']								= "Nuevo Stream";
$lang['streams:edit_stream']							= "Editar Stream";
$lang['streams:about_stream']							= "Acerca del Stream";
$lang['streams:title_column']							= "Columna de Título";
$lang['streams:sort_method']							= "Método de Orden";
$lang['streams:add_entry']								= "Nueva Entrada";
$lang['streams:edit_entry']								= "Editar Entrada";
$lang['streams:view_options']							= "Opciones de Vista";
$lang['streams:stream_view_options']					= "Opciones de Vista del Stream";
$lang['streams:backup_table']							= "Respalda Tabla del Stream";
$lang['streams:delete_stream']							= "Elimina Stream";
$lang['streams:entry']									= "Entrada";
$lang['streams:field_types']							= "Tipos de Campo"; // @done
$lang['streams:field_type']								= "Tipo de Campo"; // @done
$lang['streams:database_table']							= "Tabla de Base de Datos"; // @done
$lang['streams:size']									= "Tamaño"; // @done
$lang['streams:num_of_entries']							= "Número de Entradas"; // @done
$lang['streams:num_of_fields']							= "Número de Campos"; // @done
$lang['streams:last_updated']							= "Última actualización"; // @done
$lang['streams:export_schema']							= "Export Schema"; #translate

/* Startup */

$lang['streams:start.add_one']							= "agregar uno";
$lang['streams:start.no_fields']						= "No hay campos todavía. Para comenzar, puedes";
$lang['streams:start.no_assign'] 						= "Parece que no hay campos para este stream todavía. Para comenzar, puedes";
$lang['streams:start.add_field_here']					= "agregar un campo aquí";
$lang['streams:start.create_field_here']				= "crear un campo aquí";
$lang['streams:start.no_streams']						= "No hay streams todavía. Puedes comenzar";
$lang['streams:start.no_streams_yet']					= "There are no streams yet."; #translate
$lang['streams:start.adding_one']						= "agregando uno";
$lang['streams:start.no_fields_to_add']					= "No Hay Campos Para Agregar";
$lang['streams:start.no_fields_msg']					= "No hay campos para agregar a este stream. En PyroStreams, tipos de campo pueden ser compartidos entre streams y tienen que ser creados antes de poder asignarlos al stream. Puedes comenzar con";
$lang['streams:start.adding_a_field_here']				= "agregar un campo aquí";
$lang['streams:start.no_entries']						= "No hay entradas para <strong>%s</strong> todavía. Para comenzar, puedes";
$lang['streams:add_fields']								= "asignar campos";
$lang['streams:no_entries']								= 'No entries'; #translate
$lang['streams:add_an_entry']							= "crear un campo";
$lang['streams:to_this_stream_or']						= "a este stream o";
$lang['streams:no_field_assign']						= "No Hay Campos Asignados";
$lang['streams:no_fields_msg_first']					= "Looks like there are no fields yet for this stream."; #translate
$lang['streams:no_field_assign_msg']					= "Parece que no hay campos para este stream. Antes de entrar datos, tienes que";
$lang['streams:add_some_fields']						= "asignar varios campos";
$lang['streams:start.before_assign']					= "Antes de asignar campos a un stream, tienes que crear un campo. Puedes";
$lang['streams:start.no_fields_to_assign']				= "Parece que no hay campos disponibles para ser asignados. Antes de que puedas asignar campos tienes que ";

/* Buttons */

$lang['streams:yes_delete']								= "Sí, Elimina";
$lang['streams:no_thanks']								= "No Gracias";
$lang['streams:new_field']								= "Nuevo Campo";
$lang['streams:edit']									= "Editar";
$lang['streams:delete']									= "Eliminar";
$lang['streams:remove']									= "Remover";
$lang['streams:reset']									= "Reajustar"; // @done

/* Misc */

$lang['streams:field_singular']							= "campo";
$lang['streams:field_plural']							= "campos";
$lang['streams:by_title_column']						= "Por Columna Título";
$lang['streams:manual_order']							= "Orden Manual";
$lang['streams:stream_data_line']						= "Editar datos básicos del stream.";
$lang['streams:view_options_line'] 						= "Escoge que columnas deberían ser visibles en la página de lista de datos.";
$lang['streams:backup_line']							= "Respalda y descarga la tabla del stream en un archivo zip.";
$lang['streams:permanent_delete_line']					= "Permanentemente elimina un stream y todos sus datos.";
$lang['streams:choose_a_field_type']					= "Selecciona un tipo de campo"; // @done
$lang['streams:choose_a_field']							= "Selecciona un campo"; // @done

/* reCAPTCHA */

$lang['recaptcha_class_initialized'] 					= "Librería reCaptcha Iniciada";
$lang['recaptcha_no_private_key']						= "No has provisto la llave API para Recaptcha";
$lang['recaptcha_no_remoteip'] 							= "Por razones de seguridad, tienes que pasar el ip remoto a reCAPTCHA";
$lang['recaptcha_socket_fail'] 							= "No se pudo abrir el socket";
$lang['recaptcha_incorrect_response'] 					= "Respuesta Incorrecta para Imagen de Seguridad";
$lang['recaptcha_field_name'] 							= "Imagen de Seguridad";
$lang['recaptcha_html_error'] 							= "Error cargando imagen de seguridad.  Por favor intenta de nuevo más tarde.";

/* Default Parameter Fields */

$lang['streams:max_length'] 							= "Longitud Máxima";
$lang['streams:upload_location'] 						= "Localización de Cargas (Subidas)";
$lang['streams:default_value'] 							= "Valor Predeterminado";

$lang['streams:menu_path']								= 'Menu Path'; #translate
$lang['streams:about_instructions']						= 'A short description of your stream.'; #translate
$lang['streams:slug_instructions']						= 'This will also be the database table name for your stream.'; #translate
$lang['streams:prefix_instructions']					= 'If used, this will prefix the table in the database. Useful for naming collisons.'; #translate
$lang['streams:menu_path_instructions']					= 'Where you what section and sub section this stream should show up in the menu. Separate by a forward slash. Ex: <strong>Main Section / Sub Section</strong>.'; #translate

/* End of file pyrostreams_lang.php */
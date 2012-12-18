<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['user:add_field']                        	= 'Adicionar Campo de Perfil de Utilizador';
$lang['user:profile_delete_success']           	= 'Perfil do utilizador excluído com sucesso';
$lang['user:profile_delete_failure']            = 'Houve um problema com a exclusão do seu perfil de utilizador';
$lang['profile_user_basic_data_label']  		= 'Dados Básicos';
$lang['profile_company']         	  			= 'Empresa'; 
$lang['profile_updated_on']           			= 'Atualizado a';
$lang['user:profile_fields_label']	 		 	= 'Campos Perfil';

$lang['user:register_header'] 			= 'Registo';
$lang['user:register_step1'] 			= '<strong>Etapa 1:</strong> Cadastro';
$lang['user:register_step2'] 			= '<strong>Etapa 2:</strong> Ativação';

$lang['user:login_header'] 				= 'Entrar';

// titles
$lang['user:add_title'] 				= 'Adicionar utilizador';
$lang['user:list_title'] 				= 'Listar utilizadores';
$lang['user:inactive_title'] 			= 'Utilizadores inactivos';
$lang['user:active_title'] 				= 'Utilizadores activos';
$lang['user:registred_title'] 			= 'Utilizadores registados';

// labels
$lang['user:edit_title'] 				= 'Editar o utilizador "%s"';
$lang['user:details_label'] 			= 'Detalhes';
$lang['user:first_name_label'] 			= 'Primeiro nome';
$lang['user:last_name_label'] 			= 'Último nome';
$lang['user:group_label'] 				= 'Grupo';
$lang['user:activate_label'] 			= 'Ativar';
$lang['user:password_label'] 			= 'Password';
$lang['user:password_confirm_label'] 	= 'Confirmar password';
$lang['user:name_label'] 				= 'Nome';
$lang['user:joined_label'] 				= 'Entrou em';
$lang['user:last_visit_label'] 			= 'Última visita';
$lang['user:never_label'] 				= 'Nunca';

$lang['user:no_inactives'] 				= 'Não existem utilizadores inativos.';
$lang['user:no_registred'] 				= 'Não existem utilizadores registados.';

$lang['account_changes_saved'] 			= 'As alterações na sua conta foram salvas com sucesso.';

$lang['indicates_required'] 			= 'Indica campos obrigatórios';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user:send_activation_email']            = 'Send Activation Email'; #translate
$lang['user:do_not_activate']                  = 'Inactive'; #translate
$lang['user:register_title'] 			= 'Registar';
$lang['user:activate_account_title'] 	= 'Ativar conta';
$lang['user:activate_label'] 			= 'Ativação';
$lang['user:activated_account_title'] 	= 'Contas ativadas';
$lang['user:reset_password_title'] 		= 'Redefinir password';
$lang['user:password_reset_title'] 		= 'Redefinicão de password';


$lang['user:error_username'] 			= 'O nome de utilizador selecionado já encontra-se em uso';
$lang['user:error_email'] 				= 'O endereço de email que informou já está em uso';

$lang['user:full_name'] 				= 'Nome completo';
$lang['user:first_name'] 				= 'Primeiro nome';
$lang['user:last_name'] 				= 'Último nome';
$lang['user:username'] 					= 'Nome de utilizador';
$lang['user:display_name']				= 'Nome de exibição';
$lang['user:email_use']					= 'usado para entrar';
$lang['user:remember'] 					= 'Lembrar-me';
$lang['user:group_id_label']			= 'ID de Grupo';

$lang['user:level']						= 'Papel do utilizador';
$lang['user:active']					= 'Activo';
$lang['user:lang']						= 'Idioma';

$lang['user:activation_code'] 			= 'Código de activação';

$lang['user:reset_instructions']	    = 'O seu email ou o seu username';
$lang['user:reset_password_link'] 		= 'Esqueceu-se da sua password?';

$lang['user:activation_code_sent_notice']	= 'Um e-mail foi enviado com o seu código de ativação.';
$lang['user:activation_by_admin_notice'] 	= 'O seu registo está aguardando aprovação de um administrador.';
$lang['user:registration_disabled']         = 'Desculpe, mas o registo de utilizador está desactivado.';

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user:details_section'] 			= 'Nome';
$lang['user:password_section'] 			= 'Alterar password';
$lang['user:other_settings_section'] 	= 'Outras configurações';

$lang['user:settings_saved_success'] 	= 'As configurações da sua conta de utilizador foram salvas.';
$lang['user:settings_saved_error'] 		= 'Ocorreu um erro.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user:register_btn']				= 'Registar';
$lang['user:activate_btn']				= 'Activar';
$lang['user:reset_pass_btn'] 			= 'Redefinir password';
$lang['user:login_btn'] 				= 'Entrar';
$lang['user:settings_btn'] 				= 'Guardar configurações';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user:added_and_activated_success'] 		= 'Um novo utilizador foi criado e activado.';
$lang['user:added_not_activated_success'] 		= 'Um novo utilizador foi cariado, porém, esta conta precisa ser activada.';

// Edit
$lang['user:edit_user_not_found_error'] 		= 'Utilizador não encontrado.';
$lang['user:edit_success'] 						= 'Utilizador atualizado com sucesso.';
$lang['user:edit_error'] 						= 'Ocorreu um erro ao tentar atualizar o utilizador.';

// Activate
$lang['user:activate_success'] 					= '%s utilizadors de %s foram ativados com sucesso.';
$lang['user:activate_error'] 					= 'Precisa de selecionar os utilizadors primeiro.';

// Delete
$lang['user:delete_self_error'] 				= 'Não pode remover você mesmo!';
$lang['user:mass_delete_success'] 				= '%s utilizadores de %s foram removidos com sucesso.';
$lang['user:mass_delete_error'] 				= 'Precisa de selecionar utilizadores primeiro.';

// Register
$lang['user:email_pass_missing'] 				= 'Os campos de e-mail e/ou senha não foram preenchidos.';
$lang['user:email_exists'] 						= 'O endereço de email que escolheu já está em uso por outro utilizador.';
$lang['user:register_error']				    = 'Achamos que você é um bot. Se estamos enganados pedimos as nossas desculpas.';
$lang['user:register_reasons'] 					= 'Entre para aceder a áreas especiais que normalmente são restritas. Isto significa que será conhecido, terá acesso a mais conteúdos e menos publicidade.';


// Activation
$lang['user:activation_incorrect']   			= 'A ativação falhou. Por favor, verifique os seus detalhes e tenha certeza de não estar com o CAPS LOCK ( CAIXA ALTA ) ativo.';
$lang['user:activated_message']   				= 'A sua conta foi ativada, agora pode entrar na sua conta.';


// Login
$lang['user:logged_in']							= 'Entrou na sua conta.';
$lang['user:already_logged_in'] 				= 'Já está na sua conta. Por favor, saia antes de tentar entrar.';
$lang['user:login_incorrect'] 					= 'E-mail ou senha não confere. Por favor, verifique se as suas informações de acesso estão corretas e certifique-se que o CAPS LOCK ( CAIXA ALTA ) não está ativo.';
$lang['user:inactive']   						= 'A conta que tentou aceder está desativada.<br />Verifique o seu e-mail para mais informações de como ativar a sua conta - <em>pode estar na pasta de lixo eletrônico ou spam</em>.';


// Logged Out
$lang['user:logged_out']   						= 'Saiu da sua conta.';

// Forgot Pass
$lang['user:forgot_incorrect']   				= "Nenhuma conta foi encontrada com estes detalhes.";

$lang['user:password_reset_message']   			= "A sua senha foi redefinida. Deverá receber um email em até 2h. Se não receber, verifique se o mesmo não está na sua pasta de lixo eletrônico por acidente.";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user:activation_email_subject'] 			= 'Ativação necessária';
$lang['user:activation_email_body'] 			= 'Obrigado por ativar a sua conta em %s. Para entrar no site, por favor, visite o link abaixo:';


$lang['user:activated_email_subject'] 			= 'Ativação concluída';
$lang['user:activated_email_content_line1'] 	= 'Obrigado por se registar em %s. Agora pode concluir a ativação da sua conta terminando o processo de registo clicando no seguinte link:';
$lang['user:activated_email_content_line2'] 	= 'No caso do seu programa de e-mail não reconhecer o link como deveria, por favor, copie e cole a seguinte URL e insira o seu código de ativação:';

// Reset Pass
$lang['user:reset_pass_email_subject'] 			= 'Redefinir a password';
$lang['user:reset_pass_email_body'] 			= 'A sua password em %s foi redefinida. Se não fez esta solicitação de mudança, por favor, envie um email para %s que nós resolveremos esta situação.';

// Profile
$lang['profile_of_title'] 				= 'Perfil de %s';

$lang['profile_user_details_label'] 	= 'Detalhes do utilizador';
$lang['profile_role_label'] 			= 'Grupo';
$lang['profile_registred_on_label'] 	= 'Membro desde';
$lang['profile_last_login_label'] 		= 'Última visita';
$lang['profile_male_label'] 			= 'Masculino';
$lang['profile_female_label'] 			= 'Feminino';
$lang['user:profile_fields_label']	    = 'Campos Perfil';

$lang['profile_not_set_up'] 			= 'Este utilizador não possui um perfil configurado.';

$lang['profile_edit'] 					= 'Editar o seu perfil';

$lang['profile_personal_section'] 		= 'Pessoal';

$lang['profile_display_name']			= 'Nome de exibição';
$lang['profile_dob']					= 'Data de nascimento';
$lang['profile_dob_day']				= 'Dia';
$lang['profile_dob_month']				= 'Mês';
$lang['profile_dob_year']				= 'Ano';
$lang['profile_gender']					= 'Sexo';
$lang['profile_gender_nt']				= 'Não informado';
$lang['profile_gender_male']			= 'Masculino';
$lang['profile_gender_female']			= 'Feminino';
$lang['profile_bio']					= 'Sobre mim';

$lang['profile_contact_section'] 		= 'Conctato';

$lang['profile_phone']					= 'Telefone';
$lang['profile_mobile']					= 'Telemóvel';
$lang['profile_address']				= 'Endereço';
$lang['profile_address_line1'] 			= 'Localidade';
$lang['profile_address_line2'] 			= 'Cidade';
$lang['profile_address_line3'] 			= 'Estado';
$lang['profile_address_postcode'] 		= 'Código Postal';
$lang['profile_website']				= 'WebSite';

$lang['profile_api_section']     	    = 'API Access';

$lang['profile_edit_success'] 			= 'As alterações do seu perfil foram salvas.';
$lang['profile_edit_error'] 			= 'Ocorreu um erro ao tentar gardar as alterações.';

// -- Buttons ------------------------------------------------------------------------------------------------

$lang['profile_save_btn'] 				= 'Guardar Perfil';

/* End of file users_lang.php */
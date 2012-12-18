<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['user:add_field']                        	= 'Add User Profile Field'; #translate
$lang['user:profile_delete_success']           	= 'User profile field deleted successfully'; #translate
$lang['user:profile_delete_failure']            = 'There was a problem with deleting your user profile field'; #translate
$lang['profile_user_basic_data_label']  		= 'Basic Data'; #translate
$lang['profile_company']         	  			= 'Company'; #translate
$lang['profile_updated_on']           			= 'Updated On'; #translate
$lang['user:profile_fields_label']	 		 	= 'Profile Fields'; #translate`

$lang['user:register_header'] 			= 'Cadastro';
$lang['user:register_step1'] 			= '<strong>Etapa 1:</strong> Cadastro';
$lang['user:register_step2'] 			= '<strong>Etapa 2:</strong> Ativação';

$lang['user:login_header'] 				= 'Entrar';

// titles
$lang['user:add_title'] 				= 'Adicionar usuário';
$lang['user:list_title'] 				= 'Listar usuários';
$lang['user:inactive_title'] 			= 'Usuários inativos';
$lang['user:active_title'] 				= 'Usuários ativos';
$lang['user:registred_title'] 			= 'Usuários cadastrados';

// labels
$lang['user:edit_title'] 				= 'Editar o usuário "%s"';
$lang['user:details_label'] 			= 'Detalhes';
$lang['user:first_name_label'] 			= 'Primeiro nome';
$lang['user:last_name_label'] 			= 'Último nome';
$lang['user:group_label'] 				= 'Grupo';
$lang['user:activate_label'] 			= 'Ativar';
$lang['user:password_label'] 			= 'Senha';
$lang['user:password_confirm_label'] 	= 'Confirmar senha';
$lang['user:name_label'] 				= 'Nome';
$lang['user:joined_label'] 				= 'Entrou em';
$lang['user:last_visit_label'] 			= 'Última visita';
$lang['user:never_label'] 				= 'Nunca';

$lang['user:no_inactives'] 				= 'Não existem usuários inativos.';
$lang['user:no_registred'] 				= 'Não existem usuários cadastrados.';

$lang['account_changes_saved'] 			= 'As alterações em sua conta foram salvas com sucesso.';

$lang['indicates_required'] 			= 'Indica campos obrigatórios';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user:send_activation_email']            = 'Send Activation Email'; #translate
$lang['user:do_not_activate']                  = 'Inactive'; #translate
$lang['user:register_title'] 			= 'Cadastrar';
$lang['user:activate_account_title'] 	= 'Ativar conta';
$lang['user:activate_label'] 			= 'Ativação';
$lang['user:activated_account_title'] 	= 'Contas ativadas';
$lang['user:reset_password_title'] 		= 'Redefinir senha';
$lang['user:password_reset_title'] 		= 'Redefinicão de senha';


$lang['user:error_username'] 			= 'O nome de usuário selecionado já encontra-se em uso';
$lang['user:error_email'] 				= 'O endereço de email que você informou já está em uso';

$lang['user:full_name'] 				= 'Nome completo';
$lang['user:first_name'] 				= 'Primeiro nome';
$lang['user:last_name'] 				= 'Último nome';
$lang['user:username'] 					= 'Nome de usuário';
$lang['user:display_name']				= 'Nome de exibição';
$lang['user:email_use']					= 'usado para entrar';
$lang['user:remember'] 					= 'Lembrar-me';
$lang['user:group_id_label']			= 'ID de Grupo';

$lang['user:level']						= 'Papel de usuário';
$lang['user:active']					= 'Ativo';
$lang['user:lang']						= 'Idioma';

$lang['user:activation_code'] 			= 'Código de ativação';

$lang['user:reset_instructions']			   = 'Enter your email address or username'; #translate
$lang['user:reset_password_link'] 		= 'Esqueceu sua senha?';

$lang['user:activation_code_sent_notice']	= 'Um e-mail foi enviado com o seu código de ativação.';
$lang['user:activation_by_admin_notice'] 	= 'Seu cadastro está aguardando aprovação de um administrador.';
$lang['user:registration_disabled']            = 'Sorry, but the user registration is disabled.'; #translate

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user:details_section'] 			= 'Nome';
$lang['user:password_section'] 			= 'Trocar senha';
$lang['user:other_settings_section'] 	= 'Outras configurações';

$lang['user:settings_saved_success'] 	= 'As configurações de sua conta de usuário foram salvas.';
$lang['user:settings_saved_error'] 		= 'Ocorreu um erro.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user:register_btn']				= 'Cadastrar';
$lang['user:activate_btn']				= 'Ativar';
$lang['user:reset_pass_btn'] 			= 'Redefinir senha';
$lang['user:login_btn'] 				= 'Entrar';
$lang['user:settings_btn'] 				= 'Salvar configurações';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user:added_and_activated_success'] 		= 'Um novo usuário foi criado e ativado.';
$lang['user:added_not_activated_success'] 		= 'Um novo usuário foi cariado, porém, esta conta precisa ser ativada.';

// Edit
$lang['user:edit_user_not_found_error'] 		= 'Usuário não encontrado.';
$lang['user:edit_success'] 						= 'Usuário atualizado com sucesso.';
$lang['user:edit_error'] 						= 'Ocorreu um erro ao tentar atualizar o usuário.';

// Activate
$lang['user:activate_success'] 					= '%s usuários de %s foram ativados com sucesso.';
$lang['user:activate_error'] 					= 'Você precisa selecionar os usuários primeiro.';

// Delete
$lang['user:delete_self_error'] 				= 'Você não pode remover você mesmo!';
$lang['user:mass_delete_success'] 				= '%s usuários de %s foram removidos com sucesso.';
$lang['user:mass_delete_error'] 				= 'Você precisa selecionar usuários primeiro.';

// Register
$lang['user:email_pass_missing'] 				= 'Os campos de e-mail e/ou senha não foram preenchidos.';
$lang['user:email_exists'] 						= 'O endereço de email que você escolheu já está em uso por outro usuário.';
$lang['user:register_error']				   = 'We think you are a bot. If we are mistaken please accept our apologies.'; #translate
$lang['user:register_reasons'] 					= 'Entre para acessar áreas especiais que normalmente são restritas. Isto significa que você será relembrado, terá acesso a mais conteúdos e menos publicidade.';


// Activation
$lang['user:activation_incorrect']   			= 'A ativação falhou. Por favor, verifique seus detalhes e tenha certeza de não estar com o CAPS LOCK ( CAIXA ALTA ) ativo.';
$lang['user:activated_message']   				= 'Sua conta foi ativada, agora você pode entrar em sua conta.';


// Login
$lang['user:logged_in']							= 'Você entrou em sua conta.';
$lang['user:already_logged_in'] 				= 'Você já está em sua conta. Por favor, saia antes de tentar entrar.';
$lang['user:login_incorrect'] 					= 'E-mail ou senha não confere. Por favor, verifique se as suas informações de acesso estão corretas e certifique-se que o CAPS LOCK ( CAIXA ALTA ) não esteja ativo.';
$lang['user:inactive']   						= 'A conta que você tentou acessar está desativada.<br />Verifique o seu e-mail para maiores informações de como ativar a sua conta - <em>pode estar na pasta de lixo eletrônico</em>.';


// Logged Out
$lang['user:logged_out']   						= 'Você saiu.';

// Forgot Pass
$lang['user:forgot_incorrect']   				= "Nenhuma conta foi encontrada com estes detalhes.";

$lang['user:password_reset_message']   			= "Sua senha foi redefinida. Você deverá receber um email em até 2h. Se você não receber, verifique se o mesmo não está na sua pasta de lixo eletrônico por acidente.";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user:activation_email_subject'] 			= 'Ativação necessária';
$lang['user:activation_email_body'] 			= 'Obrigado por ativar sua conta em %s. Para entrar no site, por favor, visite o link abaixo:';


$lang['user:activated_email_subject'] 			= 'Ativação concluída';
$lang['user:activated_email_content_line1'] 	= 'Obrigado por se cadastrar em %s. Agora você pode concluir a ativação de sua conta terminando o processo de cadastro clicando no seguinte link:';
$lang['user:activated_email_content_line2'] 	= 'No caso de seu programa de e-mail não reconhecer o link como deveria, por favor, copie e cole a seguinte URL e entre o seu código de ativação:';

// Reset Pass
$lang['user:reset_pass_email_subject'] 			= 'Redefinição de senha';
$lang['user:reset_pass_email_body'] 			= 'Sua senha em %s foi redefinida. Se você não fez esta solicitação de mudança, por favor, envie um email para %s que nós resolveremos esta situação.';

// Profile
$lang['profile_of_title'] 				= 'Perfil de %s';

$lang['profile_user_details_label'] 	= 'Detalhes do usuário';
$lang['profile_role_label'] 			= 'Grupo';
$lang['profile_registred_on_label'] 	= 'Membro desde';
$lang['profile_last_login_label'] 		= 'Última visita';
$lang['profile_male_label'] 			= 'Masculino';
$lang['profile_female_label'] 			= 'Feminino';

$lang['profile_not_set_up'] 			= 'Este usuário não possui um perfil configurado.';

$lang['profile_edit'] 					= 'Editar seu perfil';

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

$lang['profile_contact_section'] 		= 'Contato';

$lang['profile_phone']					= 'Telefone';
$lang['profile_mobile']					= 'Celular';
$lang['profile_address']				= 'Endereço';
$lang['profile_address_line1'] 			= 'Bairro';
$lang['profile_address_line2'] 			= 'Cidade';
$lang['profile_address_line3'] 			= 'Estado';
$lang['profile_address_postcode'] 		= 'CEP/Código Postal';
$lang['profile_website']				= 'Site';

$lang['profile_messenger_section'] 		= 'Mensageiros instantâneos';

$lang['profile_msn_handle'] 			= 'MSN (Live Messenger)';
$lang['profile_aim_handle'] 			= 'AIM';
$lang['profile_yim_handle'] 			= 'Yahoo! messenger';
$lang['profile_gtalk_handle'] 			= 'GTalk';

$lang['profile_avatar_section'] 		= 'Avatar';
$lang['profile_social_section'] 		= 'Social';

$lang['profile_gravatar'] 				= 'Gravatar';
$lang['profile_twitter'] 				= 'Twitter';

$lang['profile_edit_success'] 			= 'Seu perfil foi salvo.';
$lang['profile_edit_error'] 			= 'Ocorreu um erro.';

// -- Buttons ------------------------------------------------------------------------------------------------

$lang['profile_save_btn'] 				= 'Salvar alterações no perfil';

/* End of file users_lang.php */
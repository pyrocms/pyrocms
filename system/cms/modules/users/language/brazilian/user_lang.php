<?php defined('BASEPATH') OR exit('No direct script access allowed');

$lang['user_register_header'] 			= 'Cadastro';
$lang['user_register_step1'] 			= '<strong>Etapa 1:</strong> Cadastro';
$lang['user_register_step2'] 			= '<strong>Etapa 2:</strong> Ativação';

$lang['user_login_header'] 				= 'Entrar';

// titles
$lang['user_add_title'] 				= 'Adicionar usuário';
$lang['user_list_title'] 				= 'Listar usuários';
$lang['user_inactive_title'] 			= 'Usuários inativos';
$lang['user_active_title'] 				= 'Usuários ativos';
$lang['user_registred_title'] 			= 'Usuários cadastrados';

// labels
$lang['user_edit_title'] 				= 'Editar o usuário "%s"';
$lang['user_details_label'] 			= 'Detalhes';
$lang['user_first_name_label'] 			= 'Primeiro nome';
$lang['user_last_name_label'] 			= 'Último nome';
$lang['user_email_label'] 				= 'E-mail';
$lang['user_group_label'] 				= 'Grupo';
$lang['user_activate_label'] 			= 'Ativar';
$lang['user_password_label'] 			= 'Senha';
$lang['user_password_confirm_label'] 	= 'Confirmar senha';
$lang['user_name_label'] 				= 'Nome';
$lang['user_joined_label'] 				= 'Entrou em';
$lang['user_last_visit_label'] 			= 'Última visita';
$lang['user_actions_label'] 			= 'Ações';
$lang['user_never_label'] 				= 'Nunca';
$lang['user_delete_label'] 				= 'Remover';
$lang['user_edit_label'] 				= 'Editar';
$lang['user_view_label'] 				= 'Visualizar';

$lang['user_no_inactives'] 				= 'Não existem usuários inativos.';
$lang['user_no_registred'] 				= 'Não existem usuários cadastrados.';

$lang['account_changes_saved'] 			= 'As alterações em sua conta foram salvas com sucesso.';

$lang['indicates_required'] 			= 'Indica campos obrigatórios';

// -- Registration / Activation / Reset Password ----------------------------------------------------------

$lang['user_register_title'] 			= 'Cadastrar';
$lang['user_activate_account_title'] 	= 'Ativar conta';
$lang['user_activate_label'] 			= 'Ativação';
$lang['user_activated_account_title'] 	= 'Contas ativadas';
$lang['user_reset_password_title'] 		= 'Redefinir senha';
$lang['user_password_reset_title'] 		= 'Redefinicão de senha';  


$lang['user_error_username'] 			= 'O nome de usuário selecionado já encontra-se em uso';
$lang['user_error_email'] 				= 'O endereço de email que você informou já está em uso';

$lang['user_full_name'] 				= 'Nome completo';
$lang['user_first_name'] 				= 'Primeiro nome';
$lang['user_last_name'] 				= 'Último nome';
$lang['user_username'] 					= 'Nome de usuário';
$lang['user_display_name']				= 'Nome de exibição';
$lang['user_email_use']					= 'usado para entrar';
$lang['user_email'] 					= 'E-mail';
$lang['user_confirm_email'] 			= 'Confirmar e-mail';
$lang['user_password'] 					= 'Senha';
$lang['user_remember'] 					= 'Lembrar-me';
$lang['user_confirm_password'] 			= 'Confirmar Senha';
$lang['user_group_id_label']			= 'ID de Grupo';

$lang['user_level']						= 'Papel de usuário';
$lang['user_active']					= 'Ativo';
$lang['user_lang']						= 'Idioma';

$lang['user_activation_code'] 			= 'Código de ativação';

$lang['user_reset_password_link'] 		= 'Esqueceu sua senha?';

$lang['user_activation_code_sent_notice']	= 'Um e-mail foi enviado com o seu código de ativação.';
$lang['user_activation_by_admin_notice'] 	= 'Seu cadastro está aguardando aprovação de um administrador.';

// -- Settings ---------------------------------------------------------------------------------------------

$lang['user_details_section'] 			= 'Nome';
$lang['user_password_section'] 			= 'Trocar senha';
$lang['user_other_settings_section'] 	= 'Outras configurações';

$lang['user_settings_saved_success'] 	= 'As configurações de sua conta de usuário foram salvas.';
$lang['user_settings_saved_error'] 		= 'Ocorreu um erro.';

// -- Buttons ----------------------------------------------------------------------------------------------

$lang['user_register_btn']				= 'Cadastrar';
$lang['user_activate_btn']				= 'Ativar';
$lang['user_reset_pass_btn'] 			= 'Redefinir senha';
$lang['user_login_btn'] 				= 'Entrar';
$lang['user_settings_btn'] 				= 'Salvar configurações';

// -- Errors & Messages ------------------------------------------------------------------------------------

// Create
$lang['user_added_and_activated_success'] 		= 'Um novo usuário foi criado e ativado.';
$lang['user_added_not_activated_success'] 		= 'Um novo usuário foi cariado, porém, esta conta precisa ser ativada.';

// Edit
$lang['user_edit_user_not_found_error'] 		= 'Usuário não encontrado.';
$lang['user_edit_success'] 						= 'Usuário atualizado com sucesso.';
$lang['user_edit_error'] 						= 'Ocorreu um erro ao tentar atualizar o usuário.';

// Activate
$lang['user_activate_success'] 					= '%s usuários de %s foram ativados com sucesso.';
$lang['user_activate_error'] 					= 'Você precisa selecionar os usuários primeiro.';

// Delete
$lang['user_delete_self_error'] 				= 'Você não pode remover você mesmo!';
$lang['user_mass_delete_success'] 				= '%s usuários de %s foram removidos com sucesso.';
$lang['user_mass_delete_error'] 				= 'Você precisa selecionar usuários primeiro.';

// Register
$lang['user_email_pass_missing'] 				= 'Os campos de e-mail e/ou senha não foram preenchidos.';
$lang['user_email_exists'] 						= 'O endereço de email que você escolheu já está em uso por outro usuário.';
$lang['user_register_reasons'] 					= 'Entre para acessar áreas especiais que normalmente são restritas. Isto significa que você será relembrado, terá acesso a mais conteúdos e menos publicidade.';


// Activation
$lang['user_activation_incorrect']   			= 'A ativação falhou. Por favor, verifique seus detalhes e tenha certeza de não estar com o CAPS LOCK ( CAIXA ALTA ) ativo.';
$lang['user_activated_message']   				= 'Sua conta foi ativada, agora você pode entrar em sua conta.';


// Login
$lang['user_logged_in']							= 'Você entrou em sua conta.';
$lang['user_already_logged_in'] 				= 'Você já está em sua conta. Por favor, saia antes de tentar entrar.';
$lang['user_login_incorrect'] 					= 'E-mail ou senha não confere. Por favor, verifique se as suas informações de acesso estão corretas e certifique-se que o CAPS LOCK ( CAIXA ALTA ) não esteja ativo.';
$lang['user_inactive']   						= 'A conta que você tentou acessar está desativada.<br />Verifique o seu e-mail para maiores informações de como ativar a sua conta - <em>pode estar na pasta de lixo eletrônico</em>.';


// Logged Out
$lang['user_logged_out']   						= 'Você saiu.';

// Forgot Pass
$lang['user_forgot_incorrect']   				= "Nenhuma conta foi encontrada com estes detalhes.";

$lang['user_password_reset_message']   			= "Sua senha foi redefinida. Você deverá receber um email em até 2h. Se você não receber, verifique se o mesmo não está na sua pasta de lixo eletrônico por acidente.";

// Emails ----------------------------------------------------------------------------------------------------

// Activation
$lang['user_activation_email_subject'] 			= 'Ativação necessária';
$lang['user_activation_email_body'] 			= 'Obrigado por ativar sua conta em %s. Para entrar no site, por favor, visite o link abaixo:';


$lang['user_activated_email_subject'] 			= 'Ativação concluída';
$lang['user_activated_email_content_line1'] 	= 'Obrigado por se cadastrar em %s. Agora você pode concluir a ativação de sua conta terminando o processo de cadastro clicando no seguinte link:';
$lang['user_activated_email_content_line2'] 	= 'No caso de seu programa de e-mail não reconhecer o link como deveria, por favor, copie e cole a seguinte URL e entre o seu código de ativação:';

// Reset Pass
$lang['user_reset_pass_email_subject'] 			= 'Redefinição de senha';
$lang['user_reset_pass_email_body'] 			= 'Sua senha em %s foi redefinida. Se você não fez esta solicitação de mudança, por favor, envie um email para %s que nós resolveremos esta situação.';

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
/* Location: ./system/cms/modules/users/language/brazilian/users_lang.php */
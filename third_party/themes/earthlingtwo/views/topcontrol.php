{if $ci->ion_auth->logged_in()}
{sprintf(lang('logged_in_welcome'), $user->first_name)} <a href="{site_url('users/logout')}">{lang('logout_label')}</a>

	{if $ci->settings->item('enable_profiles')}
		<br />{anchor('edit-profile', lang('edit_profile_label'))}
	{/if}
	
	<br />{anchor('edit-settings', lang('settings_label'))}
	
	{if $this->ion_auth->is_admin()}
		 <br />{anchor('admin', lang('cp_title'), 'target="_blank"')}
	{/if}
	
{else}
	{anchor('users/login', lang('user_login_btn'))} <br />{anchor('register', lang('user_register_btn'))}
{/if}
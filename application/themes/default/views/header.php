<div class="float-left">
	<h1>{$ci->settings->item('site_name')}</h1>
	<h2>{$ci->settings->item('site_slogan')}</h2>
</div>

<div class="float-right" style="padding:1em;text-align:right">
	{if $ci->session->userdata('user_id')}
		{sprintf lang('logged_in_welcome') cat($user->first_name ' ' $user->last_name)} <a href="{site_url('users/logout')}">{lang('logout_label')}</a><br/>
	
		{if $ci->settings->item('enable_profiles')}
			{anchor('edit-profile', lang('edit_profile_label'))} | 
		{/if}
		
		{anchor('edit-settings', lang('settings_label'))}
		
		{if $ci->user_lib->check_role('admin')}
			 | {anchor('admin', lang('cp_title'), 'target="_blank"')}
		{/if}
		
	{else}
		{$ci->load->view('users/login_small')}
	{/if}
</div>
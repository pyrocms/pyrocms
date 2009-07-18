<h2><?=lang('user_register_header') ?></h2>

<p>
	<?=lang('user_register_step1') ?> -&gt; 
	<span class="spacer-right" style="background:#FFFF99;"><?=lang('user_register_step2') ?></span>
</p>

<p><?=$this->lang->line('user_activated_message'); ?></p>

<?=form_open('users/login', array('id'=>'login')); ?>

	<p>
		<label for="email"><?=lang('user_email'); ?></label>
		<?=form_input('email', $activated_email) ?>
	</p>
	
	<p>	
		<label for="password"><?=lang('user_password'); ?></label>
		<?=form_password('password') ?>
	</p>
	
	<p><input type="image" src="<?=image_path('admin/fcc/btn-login.jpg');?>" value="<?=lang('user_login_btn') ?>" name="btnLogin" /></p>
	
<?=form_close(); ?>
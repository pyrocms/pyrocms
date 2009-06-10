<h2><?=lang('user_register_header') ?></h2>

<p>
	<?=lang('user_register_step1') ?> -&gt; 
	<span class="spacer-right" style="background:#FFFF99;"><?=lang('user_register_step2') ?></span>
</p>

<? if(!empty($error_string)):?>
<div class="error-box"><?=$error_string;?></div>
<? endif;?>

<?=form_open('users/activate'); ?>
	
<p>
	<label for="email"><?=lang('user_email') ?></label><br/>
	<input type="text"name="email" maxlength="50" value="<?= isset($user->email) ? $user->email : '' ?>" />
</p>

<p>
	<label for="activation_code"><?=lang('user_activation_code') ?></label><br/>
	<input type="text"name="activation_code" maxlength="8" />
</p>

<?=form_submit('btnSubmit', lang('user_activate_btn')) ?>
<?=form_close(); ?>
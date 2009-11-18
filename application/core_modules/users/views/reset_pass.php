<h2><?= lang('user_reset_password_title');?></h2>

<? if(!empty($error_string)):?>
<div class="error-box"><?=$error_string;?></div>
<? endif;?>

<?=form_open('users/reset_pass', array('id'=>'reset_pass')); ?>

<p class="float-left spacer-right">
	<label for="first_name"><?=lang('user_first_name') ?></label><br/>
	<input type="text"name="first_name" maxlength="40" value="<?= isset($first_name) ? $first_name : ''; ?>" />
</p>

<p>
	<label for="last_name"><?=lang('user_last_name') ?></label><br/>
	<input type="text"name="last_name" maxlength="40" value="<?= isset($last_name) ? $last_name : ''; ?>" />
</p>

<p>
	<label for="email">E-mail</label><br/>
	<input type="text"name="email" maxlength="100" value="<?= isset($email) ? $email : ''; ?>" />
</p>

<?=form_submit('btnSubmit', lang('user_reset_pass_btn')) ?>
<?=form_close(); ?>
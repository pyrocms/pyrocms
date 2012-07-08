<section class="title">
	<h3><?php echo lang('header'); ?></h3>
</section>

<section class="item">
	<p><?php echo lang('intro_text'); ?></p>
</section>

<?php echo form_open(uri_string(), 'id="install_frm"'); ?>
	
	<input type="hidden" id="site_ref" name="site_ref" value="default" />

	<section class="title">
		<h3><?php echo lang('default_user'); ?></h3>
	</section>
	
	<section class="item">

	<div class="input">
		<label for="username"><?php echo lang('username'); ?></label>
		<?php echo form_input(array(
			'id' => 'username',
			'name' => 'user[username]',
			'value' => set_value('user[username]')
		)) ?>
	</div>

	<div class="input">
		<label for="firstname"><?php echo lang('firstname'); ?></label>
		<?php echo form_input(array(
			'id' => 'firstname',
			'name' => 'user[firstname]',
			'value' => set_value('user[firstname]')
		)) ?>
	</div>

	<div class="input">
		<label for="lastname"><?php echo lang('lastname'); ?></label>
		<?php echo form_input(array(
			'id' => 'lastname',
			'name' => 'user[lastname]',
			'value' => set_value('user[lastname]')
		)) ?>
	</div>

	<div class="input">
		<label for="email"><?php echo lang('email'); ?></label>
		<?php echo form_input(array(
			'id' => 'email',
			'name' => 'user[email]',
			'value' => set_value('user[email]')
		)) ?>
	</div>

	<div class="input">
		<label for="password"><?php echo lang('password'); ?></label>
		
		<div class="password-wrapper">
			<?php echo form_password(array(
				'id' => 'password',
				'name' => 'user[password]',
			)) ?>

			<div id="progressbar">
				<div id="progress"></div>
			</div>
			<div id="status">
				<div><span id="complexity">0%</span> Complex</div>
			</div>

		</div>
			<br style="clear:both" />
	</div>

	<hr />

	<input class="btn orange" id="next_step" type="submit" id="submit" value="<?php echo lang('finish'); ?>" />

<?php echo form_close(); ?>
</section>
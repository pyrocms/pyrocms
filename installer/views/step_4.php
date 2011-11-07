<section class="title">
	<h3><?php echo lang('header'); ?></h3>
</section>

<section class="item">
	<p><?php echo lang('intro_text'); ?></p>
</section>

<?php echo form_open(uri_string(), 'id="install_frm"'); ?>
	
	<section class="title">
		<h3><?php echo lang('db_settings'); ?></h3>
	</section>
	
	<section class="item">
	<div class="input">
		<label for="database"><?php echo lang('database'); ?></label><br>
		<input type="text" id="database" class="input_text" name="database" value="<?php echo set_value('database'); ?>" />
		
		<a href="#" class="tooltip-s" title="Explanations here. Need to add for multi lang.">
			<span class="help">?</span>
		</a>
	</div>
	
	<hr>

	<div class="input">
		<label for="create_db"><?php echo lang('db_create'); ?></label><br>
		<input type="checkbox" name="create_db" value="true" id="create_db" />
		<small>(<?php echo lang('db_notice'); ?>)</small>
		
		<a href="#" class="tooltip-s" title="Explanations here. Need to add for multi lang.">
			<span class="help">?</span>
		</a>
	</div>

	<br>

		<input type="hidden" id="site_ref" name="site_ref" value="default" />
		
	</section>
	
	<section class="title">
		<h3><?php echo lang('default_user'); ?></h3>
	</section>
	
	<section class="item">

	<div class="input">
		<label for="user_name"><?php echo lang('user_name'); ?></label><br>
		<?php
			echo form_input(array(
				'id' => 'user_name',
				'name' => 'user_name',
				'value' => set_value('user_name')
			));
		?>
		
		<a href="#" class="tooltip-s" title="Explanations here. Need to add for multi lang.">
			<span class="help">?</span>
		</a>
	</div>

	<div class="input">
		<label for="user_firstname"><?php echo lang('first_name'); ?></label><br>
		<?php
			echo form_input(array(
				'id' => 'user_firstname',
				'name' => 'user_firstname',
				'value' => set_value('user_firstname')
			));
		?>
		
		<a href="#" class="tooltip-s" title="Explanations here. Need to add for multi lang.">
			<span class="help">?</span>
		</a>
	</div>

	<div class="input">
		<label for="user_lastname"><?php echo lang('last_name'); ?></label><br>
		<?php
			echo form_input(array(
				'id' => 'user_lastname',
				'name' => 'user_lastname',
				'value' => set_value('user_lastname')
			));
		?>
		
		<a href="#" class="tooltip-s" title="Explanations here. Need to add for multi lang.">
			<span class="help">?</span>
		</a>
	</div>

	<div class="input">
		<label for="user_email"><?php echo lang('email'); ?></label><br>
		<?php
			echo form_input(array(
				'id' => 'user_email',
				'name' => 'user_email',
				'value' => set_value('user_email')
			));
		?>
		
		<a href="#" class="tooltip-s" title="Explanations here. Need to add for multi lang.">
			<span class="help">?</span>
		</a>
	</div>

	<div class="input">
		<label for="user_password"><?php echo lang('password'); ?></label><br>
		<?php
			echo form_password(array(
				'id' => 'user_password',
				'name' => 'user_password',
				'value' => set_value('user_password')
			));
		?>
		
		<a href="#" class="tooltip-s" title="Explanations here. Need to add for multi lang.">
			<span class="help">?</span>
		</a>
	</div>

	<div id="notification">
	   <p class="text" id="confirm_pass"></p>
	</div>
	
	<hr>

	<input class="button" id="next_step" type="submit" id="submit" value="<?php echo lang('finish'); ?>" />

<?php echo form_close(); ?>
</section>
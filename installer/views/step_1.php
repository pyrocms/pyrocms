<!-- Intro page -->
<h2>{header}</h2>

<p class="text">{intro_text}</p>

<h3>{db_settings}</h3>

<p class="text">{db_text}</p>

<?php echo form_open(uri_string(), 'id="install_frm"'); ?>
	<p>
		<label for="hostname">{server}</label>
		<?php echo form_input('hostname', $this->session->userdata('hostname')); ?>
	</p>
	<p>
		<?php echo lang('username','username'); ?>
		<?php echo form_input('username', $this->session->userdata('username')); ?>
	</p>
	<p>
		<?php echo lang('password','password'); ?>
		<?php echo form_password('password', $this->session->userdata('password')); ?>
	</p>
	<p>
		<?php echo lang('portnr','port'); ?>
		<?php echo form_input('port', set_value('port', $port)); ?>
	</p>
	
	<h3>{server_settings}</h3>

	<p>
		<?php echo lang('httpserver','httpserver'); ?>
		<?php echo form_dropdown('http_server', $server_options, $this->session->userdata('http_server')); ?>
	</p>
	
	<input type="hidden" name="installation_step" value="step_1" />
	
	<p id="next_step"><input type="submit" id="submit" value="{step2}" /></p>
	<br class="clear" />
<?php echo form_close(); ?>

<!-- Intro page -->
<section class="title">
	<h3>{header}</h3>
</section>
<section class="item">
	<p>{intro_text}</p>
</section>

<?php echo form_open(uri_string(), 'id="install_frm"'); ?>

<section class="title">
		<h3>{db_driver}</h3>
</section>
	<section id="db-driver" class="item">
		<div class="one_full">

			<div class="mysql one_quarter alert <?php echo $db_drivers['mysql'] ? 'success' : 'error' ?>" style="width: 22.5em">
				<img src="<?php echo base_url('assets/img/dbdrivers/mysql.png') ?>" />
				<p>{mysql_about}</p>
				<?php echo form_radio('db_driver', "mysql", $selected_db_driver, 'id="use-mysql"'.($db_drivers['mysql'] ? '' : ' disabled')) ?> 
				<?php echo lang($db_drivers['mysql'] ? 'use_mysql' : 'not_available', 'use-mysql') ?>
			</div>

			<div class="pgsql one_quarter alert <?php echo $db_drivers['pgsql'] ? 'success' : 'error' ?>" style="width: 22.5em">
				<img src="<?php echo base_url('assets/img/dbdrivers/pgsql.png') ?>" />
				<p>{pgsql_about}</p>
				<?php echo form_radio('db_driver', "pgsql", $selected_db_driver === 'pgsql', 'id="use-pgsql"'.($db_drivers['pgsql'] ? '' : ' disabled')) ?> 
				<?php echo lang($db_drivers['pgsql'] ? 'use_pgsql' : 'not_available', 'use-pgsql') ?>
			</div>

			<div class="sqlite one_quarter last alert <?php echo $db_drivers['sqlite'] ? 'success' : 'error' ?>" style="width: 22.5em">
				<img src="<?php echo base_url('assets/img/dbdrivers/sqlite.gif') ?>" style="background-color:white" />
				<p>{sqlite_about}</p>
				<?php echo form_radio('db_driver', "sqlite", $selected_db_driver === 'sqlite', 'id="use-sqlite"'.($db_drivers['sqlite'] ? '' : ' disabled')) ?> 
				<?php echo lang($db_drivers['sqlite'] ? 'use_sqlite' : 'not_available', 'use-sqlite') ?>
				</button>
			</div>
		</div>
	</section>

	<section class="title">
		<h3>{db_settings}</h3>
	</section>

	<section id="db-settings" class="item">

		<div class="input mysql pgsql">
			<label for="hostname">{db_server}</label>
		<?php echo form_input(array('id' => 'hostname', 'name' => 'hostname'), set_value('hostname', 'localhost')); ?>
	</div>

		<div class="input sqlite">
			<label for="location">{db_location}</label>
			<?php echo form_input(array( 'id' => 'location', 'name' => 'location', 'value' => set_value('location', '/var/lib/sqlite/pyrocms.db'))); ?>
		</div>

		<div class="input mysql pgsql">
			<?php echo lang('db_username', 'username'); ?>
			<?php echo form_input(array('id' => 'username', 'name' => 'username', 'value' => set_value('username'))); ?>
	</div>

		<div class="input mysql pgsql sqlite">
			<?php echo lang('db_password', 'password'); ?>
			<?php echo form_password(array( 'id' => 'password', 'name' => 'password')); ?>
			
		</div>
		
		<div class="input mysql pgsql">
			<?php echo lang('db_portnr', 'port'); ?>
			<?php echo form_input(array( 'id' => 'port', 'name' => 'port', 'value' => set_value('port', $port))) ?>
		</div>

		<div class="input mysql pgsql">
			<label for="database"><?php echo lang('db_database'); ?></label>
			<input type="text" id="database" class="input_text" name="database" value="<?php echo set_value('database'); ?>" />
		</div>

		<div class="input mysql pgsql">
			<label for="create_db"><?php echo lang('db_create'); ?></label><br>
			<input type="checkbox" name="create_db" value="1" id="create_db" <?php if($this->input->post('create_db')) { echo ' checked'; } ?> />
			<small>(<?php echo lang('db_notice'); ?>)</small>
	</div>

	<div id="confirm_db"></div>
</section>

<section class="title">
	<h3>{server_settings}</h3>
</section>
<section class="item">
	<p>{httpserver_text}</p>

	<div class="input">
		<label for="http_server">{httpserver}</label>
			<?php echo form_dropdown('http_server', $server_options, set_value('http_server'), 'id="http_server"') ?>
	</div>

	<input type="hidden" name="installation_step" value="step_1"/>
	<input type="submit" id="next_step" value="{step2}" class="btn orange"/>
</section>

<?php echo form_close(); ?>

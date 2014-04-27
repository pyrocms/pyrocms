
<?php echo form_open(uri_string(), 'id="install_frm"'); ?>

<section class="title">
	<h3>{db_driver}</h3>
</section>
<section id="db-driver" class="item">

	<div class="db-selection mysql alert <?php echo $db_drivers['mysql'] ? 'success' : 'error' ?>">
		<img alt="MySQL logo" src="<?php echo base_url('assets/img/dbdrivers/mysql.png') ?>" />
		<p>{mysql_about}</p>
		<?php echo form_radio('db_driver', "mysql", $selected_db_driver, 'id="use-mysql"'.($db_drivers['mysql'] ? '' : ' disabled')) ?>
		<?php echo lang($db_drivers['mysql'] ? 'use_mysql' : 'not_available', 'use-mysql') ?>
	</div>

	<div class="db-selection pgsql alert <?php echo $db_drivers['pgsql'] ? 'success' : 'error' ?>">
		<img alt="PostgreSQL Logo" src="<?php echo base_url('assets/img/dbdrivers/pgsql.png') ?>" />
		<p>{pgsql_about}</p>
		<?php echo form_radio('db_driver', "pgsql", $selected_db_driver === 'pgsql', 'id="use-pgsql"'.($db_drivers['pgsql'] ? '' : ' disabled')) ?>
		<?php echo lang($db_drivers['pgsql'] ? 'use_pgsql' : 'not_available', 'use-pgsql') ?>
	</div>

	<div class="db-selection sqlite last alert <?php echo $db_drivers['sqlite'] ? 'success' : 'error' ?>">
		<img alt="SQLite logo" src="<?php echo base_url('assets/img/dbdrivers/sqlite.gif') ?>" style="background-color:white" />
		<p>{sqlite_about}</p>
		<?php echo form_radio('db_driver', "sqlite", $selected_db_driver === 'sqlite', 'id="use-sqlite"'.($db_drivers['sqlite'] ? '' : ' disabled')) ?>
		<?php echo lang($db_drivers['sqlite'] ? 'use_sqlite' : 'not_available', 'use-sqlite') ?>
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
		<?php echo form_input(array( 'id' => 'location', 'name' => 'location'), set_value('location', '/var/lib/sqlite/pyrocms.db')); ?>
	</div>

	<div class="input mysql pgsql">
		<label for="username">{db_username}</label>
		<?php echo form_input(array('id' => 'username', 'name' => 'username'), set_value('username')); ?>
	</div>

	<div class="input mysql pgsql sqlite">
		<label for="password">{db_password}</label>
		<?php echo form_password(array( 'id' => 'password', 'name' => 'password')); ?>
	</div>

	<div class="input mysql pgsql">
		<label for="port">{db_portnr}</label>
		<?php echo form_input(array( 'id' => 'port', 'name' => 'port'), set_value('port', $port)); ?>
	</div>

	<div class="input mysql pgsql">
		<label for="database">{db_database}</label>
		<input type="text" id="database" class="input_text" name="database" value="<?php echo set_value('database'); ?>" />
	</div>

	<div class="input mysql pgsql">
		<label for="create_db">{db_create}</label><br>
		<input type="checkbox" name="create_db" value="1" id="create_db" <?php if ($this->input->post('create_db')) { echo ' checked'; } ?> />
		<small>({db_notice})</small>
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
		<?php echo form_dropdown('http_server', $server_options, set_value('http_server'), 'id="http_server"'); ?>
	</div>

	<input type="submit" id="next_step" value="{step2}" class="btn orange"/>
</section>

<?php echo form_close(); ?>

<div class="p">


	<section id="page-title">
		<h1><?php echo lang('global:field_types');?></h1>
	</section>


	<!-- .panel -->
	<section class="panel panel-default">
	
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo lang('addons:plugins:core_field_types') ?></h3>
		</div>

		<!-- .panel-content -->
		<div class="panel-content">

			<?php if ($core): ?>
			<table class="table n-m">
				<thead>
					<tr>
						<th><?php echo lang('name_label');?></th>
						<th class="text-center"><?php echo lang('version_label');?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($core as $c_ft): ?>
				<tr>
					<td width="60%"><?php echo $c_ft['name'] ?>
					<td class="text-center"><?php echo $c_ft['version'] ?>
				</tr>
				<?php endforeach ?>
				</tbody>
			</table>
			<?php endif ?>

		</div>
		<!-- /.panel-content -->

	</section>
	<!-- /.panel -->



	<!-- .panel -->
	<section class="panel panel-default">
	
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo lang('addons:plugins:add_on_field_types') ?></h3>
		</div>

		<!-- .panel-content -->
		<div class="panel-content">

			<?php if ( ! empty($addon)): ?>
			<table class="table n-m">
				<thead>
					<tr>
						<th><?php echo lang('name_label');?></th>
						<th class="text-center"><?php echo lang('version_label');?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($addon as $a_ft): ?>
				<tr>
					<td width="60%"><?php echo $a_ft['name'] ?>
					<td class="text-center"><?php echo $a_ft['version'] ?>
				</tr>
				<?php endforeach ?>
				</tbody>
			</table>
			<?php endif ?>

		</div>
		<!-- /.panel-content -->

	</section>
	<!-- /.panel -->


</div>
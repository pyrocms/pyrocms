<section class="padded">
<div class="container-fluid">


	<section class="box">

		<section class="box-header">
			<span class="title"><?php echo lang('global:field_types');?></span>
		</section>

		<div class="padded">

			<h2><?php echo lang('addons:plugins:core_field_types') ?></h2>

			<?php if ($core): ?>
			<table class="table table-hover" cellspacing="0">
				<thead>
					<tr>
						<th><?php echo lang('name_label');?></th>
						<th><?php echo lang('version_label');?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($core as $c_ft): ?>
				<tr>
					<td width="60%"><?php echo $c_ft['name'] ?>
					<td><?php echo $c_ft['version'] ?>
				</tr>
				<?php endforeach ?>
				</tbody>
			</table>
			<?php endif ?>

			<h2><?php echo lang('addons:plugins:add_on_field_types') ?></h2>

			<?php if ( ! empty($addon)): ?>
			<table class="table-list" cellspacing="0">
				<thead>
					<tr>
						<th><?php echo lang('name_label');?></th>
						<th><?php echo lang('version_label');?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($addon as $a_ft): ?>
				<tr>
					<td width="60%"><?php echo $a_ft['name'] ?>
					<td><?php echo $a_ft['version'] ?>
				</tr>
				<?php endforeach ?>
				</tbody>
			</table>
			<?php endif ?>

		</div>

	</section>


</div>
</section>
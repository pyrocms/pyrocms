<section class="padded">
<div class="container-fluid">


	<!-- Box -->
	<section class="box">

		<!-- Header -->
		<section class="box-header">
			<span class="title"><?php echo lang('global:field_types');?></span>
		</section>


		<!-- Box Content -->
		<section class="box-content">


			<h4 class="margin-small margin-top margin-bottom"><?php echo lang('addons:plugins:core_field_types') ?></h4>

			<?php if ($core): ?>
			<table class="table table-hover table-striped">
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

			
			<h4 class="margin-small margin-top margin-bottom"><?php echo lang('addons:plugins:add_on_field_types') ?></h4>

			<?php if ( ! empty($addon)): ?>
			<table class="table table-hover table-striped">
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


		</section>
		<!-- /Box Content -->

	</section>
	<!-- /Box -->


</div>
</section>
<section class="padded">
<div class="container-fluid">


	<section class="box">

		<section class="box-header">
			<span class="title"><?php echo $module_details['name'] ?></span>
		</section>

		<div class="padded">

			<p><?php echo lang('permissions:introduction') ?></p>

			<table class="table table-hover table-bordered table-striped">
				<thead>
					<tr>
						<th><?php echo lang('permissions:group') ?></th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($groups as $group): ?>
					<tr>
						<td><?php echo $group->description ?></td>
						<td>

							<?php if ($admin_group != $group->name):?>
								<?php echo anchor('admin/permissions/group/' . $group->id, lang('permissions:edit'), array('class'=>'btn')) ?>
							<?php else: ?>
								<?php echo lang('permissions:admin_has_all_permissions') ?>
							<?php endif ?>

						</td>
					</tr>
					<?php endforeach ?>
				</tbody>
			</table>

		</div>

	</section>


</div>
</section>
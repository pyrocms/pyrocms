<div class="accordion-group ">
<div class="accordion-heading">
	<h4><?php echo $module_details['name'] ?></h4>
</div>
<div class="accordion-body collapse in lst">
	<div class="content">
		<p><?php echo lang('permissions:introduction') ?></p>
		<table class="table table-striped" cellspacing="0">
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
					<td class="buttons actions">
						<?php if ($admin_group != $group->name):?>
						<?php echo anchor('admin/permissions/group/' . $group->id, lang('permissions:edit'), array('class'=>'button btn')) ?>
						<?php else: ?>
						<?php echo lang('permissions:admin_has_all_permissions') ?>
						<?php endif ?>
					</td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	</div>
</div>
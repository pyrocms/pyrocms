<section class="padded">
<div class="container-fluid">


	<!-- Box -->
	<section class="box">

		<!-- Header -->
		<section class="box-header">
			<span class="title"><?php echo $module_details['name'] ?></span>
		</section>


		<!-- Box Content -->
		<section class="box-content">


			<?php if ($variables): ?>

				<?php echo form_open('admin/variables/delete') ?>

					<table class="table table-hover table-striped">
						<thead>
						<tr>
							<th width="30"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
							<th width="20%"><?php echo lang('name_label');?></th>
							<th class="collapse"><?php echo lang('variables:data_label');?></th>
							<th class="collapse" width="20%"><?php echo lang('variables:syntax_label');?></th>
							<th width="140"></th>
						</tr>
						</thead>
						<tbody>
							<?php foreach ($variables as $variable): ?>
							<tr>
								<td><?php echo form_checkbox('action_to[]', $variable->id) ?></td>
								<td><?php echo $variable->name;?></td>
								<td class="collapse"><?php echo $variable->data;?></td>
								<td class="collapse"><?php form_input('', printf('{{&nbsp;variables:%s&nbsp;}}', $variable->name));?></td>
								<td class="actions">
									<?php echo anchor('admin/variables/edit/' . $variable->id, lang('buttons:edit'), 'class="btn btn-small btn-warning"') ?>
									<?php echo anchor('admin/variables/delete/' . $variable->id, lang('buttons:delete'), array('class'=>'confirm btn btn-small btn-danger')) ?>
								</td>
							</tr>
							<?php endforeach ?>
						</tbody>
					</table>

					<?php $this->load->view('admin/partials/pagination') ?>

					<div class="btn-group padding-left padding-right">
						<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )) ?>
					</div>
					
				<?php echo form_close() ?>

			<?php else: ?>
					<div class="alert margin"><?php echo lang('variables:no_variables');?></div>
			<?php endif ?>


		</section>
		<!-- /Box Content -->

	</section>
	<!-- /Box -->

</div>
</section>
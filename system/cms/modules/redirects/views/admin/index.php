<div class="padding">


	<section id="page-title">
		<h1><?php echo lang('redirects:list_title') ?></h1>
	</section>


	<!-- .panel -->
	<section class="panel panel-default">

		<!-- .panel-content -->
		<div class="panel-content">


			<?php if ( ! $redirects->isEmpty()): ?>
				
				    <?php echo form_open('admin/redirects/delete') ?>
					<table class="table no-margin">
					    <thead>
							<tr>
								<th width="15"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
								<th width="25"><?php echo lang('redirects:type');?></th>
								<th width="25%"><?php echo lang('redirects:from');?></th>
								<th><?php echo lang('redirects:to');?></th>
								<th width="200"></th>
							</tr>
					    </thead>
						<tfoot>
							<tr>
								<td colspan="5">
									<div class="inner"><?php $this->load->view('admin/partials/pagination') ?></div>
								</td>
							</tr>
						</tfoot>
					    <tbody>
						<?php foreach ($redirects as $redirect): ?>
						    <tr>
							<td><?php echo form_checkbox('action_to[]', $redirect->id) ?></td>
							<td><?php echo $redirect->type;?></td>
							<td><?php echo str_replace('%', '*', $redirect->from);?></td>
							<td><?php echo $redirect->to;?></td>
							<td class="text-right">
							    <?php echo anchor('admin/redirects/edit/' . $redirect->id, lang('redirects:edit'), 'class="btn-sm btn-warning"');?>
								<?php echo anchor('admin/redirects/delete/' . $redirect->id, lang('redirects:delete'), array('class'=>'confirm btn-sm btn-danger'));?>
							</td>
						    </tr>
						<?php endforeach ?>
					    </tbody>
					</table>

					<div class="panel-footer">
						<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )) ?>
					</div>
				    <?php echo form_close() ?>

			<?php else: ?>
				<div class="padding"><?php echo lang('redirects:no_redirects');?></div>
			<?php endif ?>


		</div>
		<!-- /.panel-content -->

	</section>
	<!-- /.panel -->


</div>

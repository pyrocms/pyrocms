<section class="content-wrapper">
<div class="container-fluid">


	<?php if ($redirects): ?>

		<section class="box">

			<section class="box-header">
				<span class="title"><?php echo lang('redirects:list_title') ?></span>
			</section>

			<div class="box-content">

		    <?php echo form_open('admin/redirects/delete') ?>
			<table class="table table-hover table-bordered table-striped">
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
					<td>
					
						<div class="btn-group pull-right">
							<?php echo anchor('admin/redirects/edit/' . $redirect->id, lang('redirects:edit'), 'class="btn edit"');?>
							<?php echo anchor('admin/redirects/delete/' . $redirect->id, lang('redirects:delete'), array('class'=>'confirm btn btn-danger'));?>
						</div>

					</td>
				    </tr>
				<?php endforeach ?>
			    </tbody>
			</table>
		
			<div class="table_action_buttons">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )) ?>
			</div>
		    <?php echo form_close() ?>
			
			</div>
		</section>

	<?php else: ?>
		
		<section class="box">

			<section class="box-header">
				<span class="title"><?php echo lang('redirects:list_title') ?></span>
			</section>

			<div class="box-content">
				<div class="no_data"><?php echo lang('redirects:no_redirects');?></div>
			</div>
			
		</section>

	<?php endif ?>


</div>
</section>
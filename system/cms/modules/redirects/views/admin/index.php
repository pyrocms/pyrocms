<?php if ($redirects): ?>
    <?php echo form_open('admin/redirects/delete'); ?>
	<table border="0" class="table-list">
	    <thead>
			<tr>
				<th width="30"><?php echo form_checkbox('action_to_all');?></th>
				<th width="25%"><?php echo lang('redirects.from');?></th>
				<th><?php echo lang('redirects.to');?></th>
				<th width="200" class="align-center"><?php echo lang('action_label'); ?></th>
			</tr>
	    </thead>
		<tfoot>
			<tr>
				<td colspan="4">
					<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
				</td>
			</tr>
		</tfoot>
	    <tbody>
		<?php foreach ($redirects as $redirect): ?>
		    <tr>
			<td><?php echo form_checkbox('action_to[]', $redirect->id); ?></td>
			<td><?php echo $redirect->from;?></td>
			<td><?php echo $redirect->to;?></td>
			<td class="align-center">
			<div class="buttons buttons-small">
			    <?php echo anchor('admin/redirects/edit/' . $redirect->id, lang('redirects.edit'), 'class="button edit"');?>
				<?php echo anchor('admin/redirects/delete/' . $redirect->id, lang('redirects.delete'), array('class'=>'confirm button delete'));?>
			</div>
			</td>
		    </tr>
		<?php endforeach; ?>
	    </tbody>
	</table>

	<div class="buttons align-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
	</div>
    <?php echo form_close(); ?>

<?php else: ?>
	<div class="blank-slate">
		<h2><?php echo lang('redirects.no_redirects');?></h2>
	</div>
<?php endif; ?>
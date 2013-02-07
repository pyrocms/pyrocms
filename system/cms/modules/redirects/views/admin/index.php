<section class="title">
	<h4><?php echo lang('redirects:list_title') ?></h4>
</section>

<?php if ($redirects): ?>

	<section class="item">
		<div class="content">

	    <?php echo form_open('admin/redirects/delete') ?>
		<table border="0" class="table-list" cellspacing="0">
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
				<td class="align-center">
				<div class="actions">
				    <?php echo anchor('admin/redirects/edit/' . $redirect->id, lang('redirects:edit'), 'class="button edit"');?>
					<?php echo anchor('admin/redirects/delete/' . $redirect->id, lang('redirects:delete'), array('class'=>'confirm button delete'));?>
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
	<section class="item">
		<div class="content">
			<div class="no_data"><?php echo lang('redirects:no_redirects');?></div>
		</div>
	</section>
<?php endif ?>
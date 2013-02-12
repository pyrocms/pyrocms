<div class="accordion-group ">
<div class="accordion-heading">
	<h4><?php echo lang('domains:list_title') ?></h4>
</div>

<?php if ($domains): ?>

<div class="accordion-body collapse in lst">
		<div class="content">

    <?php echo form_open('admin/domains/delete') ?>
	 <table class="table table-striped" cellspacing="0">
	    <thead>
			<tr>
				<th width="15"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
				<th width="25"><?php echo lang('domains:type');?></th>
				<th><?php echo lang('domains:domain');?></th>
				<th></th>
			</tr>
	    </thead>
		<tfoot>
			<tr>
				<td colspan="4">
					<div class="inner"><?php $this->load->view('admin/partials/pagination') ?></div>
				</td>
			</tr>
		</tfoot>
	    <tbody>
		<?php foreach ($domains as $domain): ?>
		    <tr>
			<td><?php echo form_checkbox('action_to[]', $domain->id) ?></td>
			<td><?php echo ($domain->type == 'park' ? lang('domains:park') : lang('domains:redirect'));?></td>
			<td><?php echo anchor('http://'.$domain->domain, $domain->domain, 'target="_blank"');?></td>
			<td class="align-right">
			<div class="actions">
			    <?php echo anchor('admin/domains/edit/' . $domain->id, lang('global:edit'), 'class="button edit btn"');?>
				<?php echo anchor('admin/domains/delete/' . $domain->id, lang('global:delete'), array('class'=>'confirm button delete btn btn-danger'));?>
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
	</div>

<?php else: ?>
	<div class="accordion-body collapse in lst">
		<div class="content">
			<div class="no_data"><?php echo lang('domains:no_domains');?></div>
		</div>
	</div>
<?php endif ?>
</div>
<?php if ($redirects): ?>
    <?php echo form_open('cms/redirects/delete'); ?>
	<table border="0" class="table-list">
	    <thead>
		<tr>
		    <th width="5%"><?php echo form_checkbox('action_to_all');?></th>
		    <th width="25%"><?php echo lang('redirects.from');?></th>
		    <th width="40%"><?php echo lang('redirects.to');?></th>
		    <th width="10%"></th>
		</tr>
	    </thead>
	    <tbody>
		<?php foreach ($redirects as $redirect): ?>
		    <tr>
			<td><?php echo form_checkbox('action_to[]', $redirect->id); ?></td>
			<td><?php echo $redirect->from;?></td>
			<td><?php echo $redirect->to;?></td>
			<td>
			    <?php echo anchor('cms/redirects/edit/'.$redirect->id, lang('redirects.edit'));?>&nbsp;&nbsp;|&nbsp;&nbsp;<?php echo anchor('cms/redirects/delete/'.$redirect->id, lang('redirects.delete'), array('class'=>'confirm'));?>
			</td>
		    </tr>
		<?php endforeach; ?>
	    </tbody>
	</table>

	<p><?php echo $pagination['links']; ?></p>

	<div class="buttons">
	    <?php echo form_submit('delete', 'Delete' ); ?>
	</div>
    <?php echo form_close(); ?>

<?php else: ?>
    <p><?php echo lang('redirects.no_redirects');?></p>
<?php endif; ?> 
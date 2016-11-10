<section class="title">
	<h4><span><a href="<?php echo site_url('admin/streams/manage/'.$stream->id); ?>"><?php echo $stream->stream_name;?></a></span> &rarr; <?php echo lang('streams:field_assignments');?></h4>
</section>

<section class="item">
<?php if ( $stream_fields ): ?>

    <table class="table-list">
		<thead>
			<tr>	
				<th></th>
			    <th><?php echo lang('streams:label.field_name');?></th>
			    <th><?php echo lang('streams:label.field_slug');?></th>
			    <th></th>
			</tr>
		</thead>
		<tbody>		
		<?php foreach ($stream_fields as $stream_field):?>
			<tr>
				<td width="30" class="handle"><?php echo Asset::img('icons/drag_handle.gif', 'Drag Handle'); ?></td>
				<td>
					<input type="hidden" name="action_to[]" value="<?php echo $stream_field->assign_id;?>" />
					<?php echo $stream_field->field_name; ?></td>
				<td><?php echo $stream_field->field_slug; ?></td>
				<td class="actions">
					<?php echo anchor('admin/streams/edit_assignment/'.$stream_field->stream_id . '/'.$stream_field->assign_id, lang('streams:edit_assign'), 'class="button"'); ?>
					<?php echo anchor('admin/streams/remove_assignment/'.$stream_field->stream_id . '/'.$stream_field->assign_id, lang('streams:remove'), 'class="button confirm"'); ?>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
    </table>

<?php echo $pagination['links']; ?>

<?php else: ?>

	<div class="no_data">
	<?php if( $total_existing_fields > 0 ): ?>
	
	No field assignments.
    
    <?php else: ?>
    
	<?php echo lang('streams:start.before_assign');?> <?php echo anchor('admin/streams/fields/add', lang('streams:start.create_field_here'))?>.
    
    <?php endif; ?>
	</div>
   
<?php endif;?>

</section>
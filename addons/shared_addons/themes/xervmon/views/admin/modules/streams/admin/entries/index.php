<div class="accordion-group">
<section class="title accordion-heading">
	<h4><?php echo '<span>'.$stream->stream_name.'</span> &rarr; '. lang('streams:stream_entries'); ?></h4>
</section>

<section class="item accordion-body collapse in lst">

<?php if ( $data ): ?>

    <table class="table-striped table">
		<thead>
			<tr>
				<?php if($stream->sorting == 'custom'): ?><th></th><?php endif; ?>
				<?php foreach( $stream->view_options as $view_option ): ?>
				<th><?php echo $stream_fields->$view_option->field_name;?></th>
				<?php endforeach; ?>
			    <th></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($data as $field => $data_item):?>
			<tr>
				<?php if($stream->sorting == 'custom'): ?><td width="30" class="handle"><?php echo Asset::img('icons/drag_handle.gif', 'Drag Handle'); ?></td><?php endif; ?>
				<?php if(is_array($stream->view_options)): foreach( $stream->view_options as $view_option ): ?>
				<td>
				
				<input type="hidden" name="action_to[]" value="<?php echo $data_item->id;?>" />
				
				<?php
				
					if( $view_option == 'created' || $view_option == 'updated' ):
					
						if($data_item->$view_option):echo date('M j Y g:i a', $data_item->$view_option); endif;
						
					elseif( $view_option == 'created_by' ):
					
						?><a href="<?php echo site_url('admin/users/edit/'. $data_item->created_by['user_id']); ?>"><?php echo $data_item->created_by['display_name']; ?></a><?php
					
					else:
					
						echo $data_item->$view_option;
					
					endif;
					
				?></td>
				<?php endforeach; endif; ?>
				<td class="actions">
				
					<?php echo anchor('admin/streams/entries/edit/'.$stream->id.'/'.$data_item->id, lang('global:edit'), 'class="button"'); ?>
					<?php echo anchor('admin/streams/entries/view/'.$stream->id.'/'.$data_item->id, lang('global:view'), 'class="button"'); ?>
					<?php echo anchor('admin/streams/entries/delete/'.$stream->id.'/'.$data_item->id, lang('global:delete'), 'class="button confirm"'); ?>
					
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
    </table>
    
<?php echo $pagination['links']; ?>

<?php else: ?>
    <div class="no_data"><?php echo sprintf(lang('streams:start.no_entries'), $stream->stream_name);?> <?php echo anchor('admin/streams/new_assignment/'.$this->uri->segment(5), lang('streams:add_fields'));?> <?php echo lang('streams:to_this_stream_or');?> <?php echo anchor('admin/streams/entries/add/'.$this->uri->segment(5), lang('streams:add_an_entry'));?>.</div>
<?php endif;?>

</section>
    </div>
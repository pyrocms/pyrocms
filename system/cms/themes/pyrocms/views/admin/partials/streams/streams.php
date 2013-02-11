<?php if (!empty($streams)): ?>
			
<table border="0" class="table-list" cellspacing="0">
	<thead>
		<tr>
		    <th><?php echo lang('streams:stream_name');?></th>
		    <th><?php echo lang('streams:stream_slug');?></th>
		    <th><?php echo lang('streams:about');?></th>
		    <th><?php echo lang('streams:total_entries');?></th>
		    <th></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($streams as $stream):?>

	<?php
	
	// Does this table exist?
	if($this->db->table_exists($stream->stream_prefix.$stream->stream_slug)):
	
		$table_exists = true;
		echo '<tr>';
	
	else:

		$table_exists = false;
		echo '<tr class="inactive">';
	
	endif;
	
	?>
			<td><?php echo lang_label($stream->stream_name); ?></td>
			<td><?php echo $stream->stream_slug; ?></td>
			<td><?php echo $stream->about; ?></td>

			<td><?php if($table_exists): echo number_format($this->streams_m->count_stream_entries($stream->stream_slug, $stream->stream_namespace)); endif; ?></td>
			
			<td class="actions">

			<?php
		
				if (isset($buttons))
				{						
					$all_buttons = array();

					foreach($buttons as $button)
					{
						$class = (isset($button['confirm']) and $button['confirm']) ? 'button confirm ' : 'button ';
						$class .= isset($button['class']) ? $button['class'] : '';
						$all_buttons[] = anchor(str_replace('-stream_id-', $stream->id, $button['url']), $button['label'], 'class="'.$class.'"');
					}
				
					echo implode('&nbsp;', $all_buttons);
					unset($all_buttons);
				}
				
			?>

			</td>
		</tr>
	<?php endforeach;?>
	</tbody>
</table>

<?php echo $pagination['links']; ?>

<?php else: ?>
	<div class="no_data">
	<?php 
	
		if (isset($no_streams_message))
		{
			echo $no_streams_message;
		}
		else
		{
			echo lang('streams:start.no_streams_yet');
		}
			
	?>
	</div>
<?php endif;?>

</div>

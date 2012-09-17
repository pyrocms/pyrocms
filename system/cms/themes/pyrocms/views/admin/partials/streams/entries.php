<?php if ($entries) { ?>

    <table class="table-list">
		<thead>
			<tr>
				<?php if($stream->sorting == 'custom'): ?><th></th><?php endif; ?>
				<?php foreach( $stream->view_options as $view_option ) { ?>
				<th><?php echo $stream_fields->$view_option->field_name;?></th>
				<?php } ?>
			    <th></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($entries as $field => $data_item) { ?>

			<tr>
				<?php if(is_array($stream->view_options)): foreach( $stream->view_options as $view_option ): ?>
				<td>
				
				<input type="hidden" name="action_to[]" value="<?php echo $data_item->id;?>" />
				
				<?php
				
					if ($view_option == 'created' or $view_option == 'updated')
					{
						if($data_item->$view_option):echo date('M j Y g:i a', $data_item->$view_option); endif;	
					}				
					elseif ($view_option == 'created_by')
					{
					
						?><a href="<?php echo site_url('admin/users/edit/'. $data_item->created_by['user_id']); ?>"><?php echo $data_item->created_by['display_name']; ?></a><?php
					}
					else
					{
						echo $data_item->$view_option;
					}
					
				?></td>
				<?php endforeach; endif; ?>
				<td class="actions">
				
					<?php
				
						if (isset($buttons))
						{						
							$all_buttons = array();

							foreach($buttons as $button)
							{
								$class = (isset($button['confirm']) and $button['confirm']) ? 'button confirm' : 'button';
								$all_buttons[] = anchor(str_replace('-entry_id-', $data_item->id, $button['url']), $button['label'], 'class="'.$class.'"');
							}
						
							echo implode('&nbsp;', $all_buttons);
							unset($all_buttons);
						}
						
					?>			
				</td>
			</tr>
		<?php } ?>
		</tbody>
    </table>
    
<?php echo $pagination['links']; ?>

<?php } else { ?>
    <div class="no_data">No data</div>
<?php } ?>
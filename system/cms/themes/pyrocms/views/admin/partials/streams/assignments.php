<?php if ( $assignments ): ?>

    <table class="table-list">
		<thead>
			<tr>	
				<th></th>
			    <th><?php echo lang('streams.label.field_name');?></th>
			    <th><?php echo lang('streams.label.field_slug');?></th>
			    <th><?php echo lang('streams.label.field_type');?></th>
			    <th></th>
			</tr>
		</thead>
		<tbody>		
		<?php foreach ($assignments as $assignment):?>
			<tr>
				<td width="30" class="handle"><?php echo Asset::img('icons/drag_handle.gif', 'Drag Handle'); ?></td>
				<td>
					<input type="hidden" name="action_to[]" value="<?php echo $assignment->assign_id;?>" />
					<?php echo $this->fields->translate_label($assignment->field_name); ?></td>
				<td><?php echo $assignment->field_slug; ?></td>
				<td><?php echo $this->type->types->{$assignment->field_type}->field_type_name; ?></td>
				<td class="actions">
					<?php
					
						$all_buttons = array();
						
						foreach($buttons as $button)
						{
							$class = (isset($button['confirm']) and $button['confirm']) ? 'button confirm' : 'button';
							$all_buttons[] = anchor(str_replace('-assign_id-', $assignment->assign_id, $button['url']), $button['label'], 'class="'.$class.'"');
						}
					
						echo implode('&nbsp;', $all_buttons);
						unset($all_buttons);
						
					?>			
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
    </table>

<?php echo $pagination['links']; ?>

<?php else: ?>

	<div class="no_data">No data.</div>
   
<?php endif;?>
<?php if ($assignments): ?>

    <table class="table table-hover table-striped">
		<thead>
			<tr>	
			    <th><?php echo lang('streams:label.field_name');?></th>
			    <th><?php echo lang('streams:label.field_slug');?></th>
			    <th><?php echo lang('streams:label.field_type');?></th>
			    <th><?php echo lang('streams:label.is_locked');?></th>
			    <th></th>
			</tr>
		</thead>
		<tbody>		
		<?php foreach ($assignments as $assignment):?>
			<tr>
				<td>
					<?php echo $this->fields->translate_label($assignment->field_name); ?></td>
				<td><?php echo $assignment->field_slug; ?></td>
				<td><?php echo $this->type->types->{$assignment->field_type}->field_type_name; ?></td>
				<td class="text-center"><?php echo $assignment->is_locked == 'yes' ? '<i class="icon-lock"></i>' : null; ?></td>
				<td>
					<div class="pull-right">
						<?php
						
							$all_buttons = array();

							if (isset($buttons))
							{
								foreach($buttons as $button)
								{
									// don't render button if field is locked and $button['locked'] is set to TRUE
									if($assignment->is_locked == 'yes' and isset($button['locked']) and $button['locked']) continue;
									$class = (isset($button['confirm']) and $button['confirm']) ? 'btn btn-small confirm' : 'btn btn-small';
									$class .= (isset($button['class']) and ! empty($button['class'])) ? ' '.$button['class'] : null;
									$all_buttons[] = anchor(str_replace('-assign_id-', $assignment->assign_id, $button['url']), $button['label'], 'class="'.$class.'"');
								}
							}
						
							echo implode('&nbsp;', $all_buttons);
							unset($all_buttons);
							
						?>
					</div>
				</td>
			</tr>
		<?php endforeach;?>
		</tbody>
    </table>

<?php echo $pagination['links']; ?>

<?php else: ?>

<div class="no_data">
	<?php
		
		if (isset($no_assignments_message) and $no_assignments_message)
		{
			echo lang_label($no_assignments_message);
		}
		else
		{
			echo lang('streams:no_field_assign');
		}

	?>
</div><!--.no_data-->

<?php endif;?>
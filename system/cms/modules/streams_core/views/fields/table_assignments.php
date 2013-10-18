<?php if (! $assignments->isEmpty()): ?>

    <table class="table-list" border="0" cellspacing="0">
		<thead>
			<tr>
				<th></th>
			    <th><?php echo lang('streams:label.field_name');?></th>
			    <th><?php echo lang('streams:label.field_slug');?></th>
			    <th><?php echo lang('streams:label.field_type');?></th>
			    <th></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($assignments as $assignment):?>
			<tr>
				<td width="30" class="handle"><?php echo Asset::img('icons/drag_handle.gif', 'Drag Handle'); ?></td>
				<td>
					<input type="hidden" name="action_to[]" value="<?php echo $assignment->id;?>" />
					<?php
						if ( ! $field_name = $assignment->field_name and $field = $assignment->field)
						{
							$field_name = $field->field_name;
						}
					 
					 	echo lang_label($field_name);
				 	?>
				</td>
				<?php if ($field = $assignment->field): ?>
					<td><?php echo $field->field_slug; ?></td>
					<td><?php echo $field->getType()->field_type_name; ?></td>
				<?php endif; ?>
				<td class="actions">
					<?php

						$all_buttons = array();

						if (isset($buttons)) {
							foreach ($buttons as $button) {
								// don't render button if field is locked and $button['locked'] is set to TRUE
								if($assignment->is_locked == 'yes' and isset($button['locked']) and $button['locked']) continue;
								$class = (isset($button['confirm']) and $button['confirm']) ? 'button confirm' : 'button';

								$url = ci()->parser->parse_string($button['url'], $assignment->toArray(), true);

								// This is kept for backwards compat
								$url = str_replace('-field_id-', $assignment->getKey(), $url);

								$all_buttons[] = anchor($url, $button['label'], 'class="'.$class.'"');
							}
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

<div class="no_data">
	<?php

		if (isset($no_assignments_message) and $no_assignments_message) {
			echo lang_label($no_assignments_message);
		} else {
			echo lang('streams:no_field_assign');
		}

	?>
</div><!--.no_data-->

<?php endif;

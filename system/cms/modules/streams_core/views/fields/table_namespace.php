<?php if ( isset($fields) and count($fields)): ?>

    <table class="table-list" border="0" cellspacing="0">
		<thead>
			<tr>
			    <th><?php echo lang('streams:label.field_name');?></th>
			    <th><?php echo lang('streams:label.field_slug');?></th>
			    <th><?php echo lang('streams:label.field_type');?></th>
			    <th><?php echo lang('pyro.actions');?></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach ($fields as $field):?>
			<tr>
				<td><?php echo $field->field_name; ?></td>
				<td><?php echo $field->field_slug; ?></td>
				<td><?php echo $field->getType()->field_type_name; ?></td>
				<td class="actions">

					<?php

						$all_buttons = array();

						foreach ($buttons as $button) {
							// don't render button if field is locked and $button['hide_locked'] is set to TRUE
							if($field->is_locked == 'yes' and isset($button['locked']) and $button['locked']) continue;
							$class = (isset($button['confirm']) and $button['confirm']) ? 'button confirm' : 'button';

							$url = ci()->parser->parse_string($button['url'], $field->toArray(), true);

							// This is kept for backwards compat
							$url = str_replace('-field_id-', $field->getKey(), $url);

							$all_buttons[] = anchor($url, $button['label'], 'class="'.$class.'"');
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
	<div class="no_data"><?php echo lang('streams:start.no_fields');?> <?php echo anchor(isset($add_uri) ? $add_uri : 'admin/streams/fields/add', lang('streams:start.add_one'), 'class="add"'); ?>.</div>
<?php endif;

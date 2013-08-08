<section class="padded">
<div class="container-fluid">


	<div class="padded">

		<?php if (!empty($fields)): ?>

		    <table class="table table-hover table-bordered table-striped">
				<thead>
					<tr>
					    <th><?php echo lang('streams:label.field_name');?></th>
					    <th><?php echo lang('streams:label.field_slug');?></th>
					    <th><?php echo lang('streams:label.field_type');?></th>
					    <th><?php echo lang('streams:label.is_locked');?></th>
					    <th><?php echo lang('pyro.actions');?></th>
					</tr>
				</thead>
				<tbody>
				<?php foreach ($fields as $field):?>
					<tr>
						<td><?php echo (lang($field->field_name)) ? lang($field->field_name) : lang_label($field->field_name); ?></td>
						<td><?php echo $field->field_slug; ?></td>
						<td><?php echo $this->type->types->{$field->field_type}->field_type_name; ?></td>
						<td class="text-center"><?php echo $field->is_locked == 'yes' ? '<i class="icon-lock"></i>' : null; ?></td>
						<td>
						
							<?php
							
								$all_buttons = array();
								
								foreach($buttons as $button)
								{
									// don't render button if field is locked and $button['hide_locked'] is set to TRUE
									if($field->is_locked == 'yes' and isset($button['locked']) and $button['locked']) continue;
									$class = (isset($button['confirm']) and $button['confirm']) ? 'btn btn-small confirm' : 'btn btn-small';
									$class .= (isset($button['class']) and ! empty($button['class'])) ? ' '.$button['class'] : null;
									$all_buttons[] = anchor(str_replace('-field_id-', $field->id, $button['url']), $button['label'], 'class="'.$class.'"');
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
		<?php endif;?>

	</div>


</div>
</section>
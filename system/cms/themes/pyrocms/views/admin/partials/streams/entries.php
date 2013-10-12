<!-- .panel-body -->
<!--<div class="panel-body">-->

	<?php $this->load->view('admin/partials/streams/filters'); ?>

	<?php if ($entries->count() > 0): ?>

		<table class="table no-margin">
			<thead>
				<tr>
					<?php if ($stream->sorting == 'custom'): ?><th></th><?php endif; ?>
					<?php foreach ($field_names as $field_name): ?>
						<th><?php echo $field_name; ?></th>
					<?php endforeach; ?>
				    <th></th>
				</tr>
			</thead>
			<tbody>
			<?php foreach ($entries as $entry) { ?>

				<tr>

					<?php if ($stream->sorting == 'custom'): ?><td width="30" class="handle"><?php echo Asset::img('icons/drag_handle.gif', 'Drag Handle'); ?></td><?php endif; ?>

					<?php if (is_array($view_options)): foreach( $view_options as $view_option ): ?>
					<td>

					<input type="hidden" name="action_to[]" value="<?php echo $entry->getKey();?>" />

					<?php if ($entry->$view_option instanceof \Carbon\Carbon) {
							
						if ($entry->$view_option): echo $entry->$view_option->format('M j Y g:i a'); endif; 

					} elseif ($view_option == 'created_by' and is_object($entry->created_by)) { ?>

						<a href="<?php echo site_url('admin/users/edit/'. $entry->created_by->id); ?>">
							<?php echo $entry->created_by->username; ?>
						</a>
				
					<?php } else {
							
							echo $entry->$view_option;
						
					} ?>

					</td>
					<?php endforeach; endif; ?>
					<td class="text-right">

						<?php

							if (isset($buttons)) {
								$all_buttons = array();

								foreach ($buttons as $button) {
									$class = (isset($button['confirm']) and $button['confirm']) ? 'confirm' : 'button';
									$class .= (isset($button['class']) and ! empty($button['class'])) ? ' '.$button['class'] : null;

									$url = ci()->parser->parse_string($button['url'], $entry->toArray(), true);

									// This is kept for backwards compatibility
									$url = str_replace('-entry_id-', $entry->getKey(), $url);

									$all_buttons[] = anchor($url, $button['label'], 'class="'.$class.'"');
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

		<?php if ($pagination): echo '<div class="panel-footer">'.$pagination['links'].'</div>'; endif; ?>

	<?php else: ?>

		<div class="padding">
			<?php

				if (isset($no_entries_message) and $no_entries_message) {
					echo lang_label($no_entries_message);
				} else {
					echo lang('streams:no_entries');
				}

			?>
		</div><!--.no_data-->

	<?php endif; ?>

<!--</div>-->
<!-- /.panel-body -->
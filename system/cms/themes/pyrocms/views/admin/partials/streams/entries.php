<?php $this->load->view('admin/partials/streams/filters'); ?>

<?php if ($entries->count() > 0) { ?>

    <table class="table-list" cellpadding="0" cellspacing="0">
		<thead>
			<tr>
					<?php if ($stream->sorting == 'custom'): ?><th></th><?php endif; ?>
					<?php foreach ($field_names as $field_slug=>$field_name): ?>
					<?php

						// Get our query string
						$query_string = array();

						// Parse it into above array
						parse_str($_SERVER['QUERY_STRING'], $query_string);

						$original_query_string = $query_string;

						// Set the order slug
						$query_string['order-'.$stream->stream_namespace.'-'.$stream->stream_slug] = $field_slug;

						// Set the sort string
						$query_string['sort-'.$stream->stream_namespace.'-'.$stream->stream_slug] = 
							isset($query_string['sort-'.$stream->stream_namespace.'-'.$stream->stream_slug])
								? ($query_string['sort-'.$stream->stream_namespace.'-'.$stream->stream_slug] == 'ASC'
									? 'DESC'
									: 'ASC')
								: 'ASC';

						// Determine our caret for this item
						$caret = false;

						if (isset($original_query_string['order-'.$stream->stream_namespace.'-'.$stream->stream_slug]) and $original_query_string['order-'.$stream->stream_namespace.'-'.$stream->stream_slug] == $field_slug)
							if (isset($original_query_string['sort-'.$stream->stream_namespace.'-'.$stream->stream_slug]))
								if ($original_query_string['sort-'.$stream->stream_namespace.'-'.$stream->stream_slug] == 'ASC')
									$caret = '&#9650;';
								else
									$caret = '&#9660;';
							else
								$caret = '&#9650;';

						?>
						<th>
							<a href="<?php echo site_url(uri_string()).'?'.http_build_query($query_string); ?>">
								<?php echo $field_name; ?>
								<?php if ($caret) echo $caret; ?>
							</a>
						</th>

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
				<td class="actions">

					<?php

						if (isset($buttons)) {
							$all_buttons = array();

							foreach ($buttons as $button) {
								$class = (isset($button['confirm']) and $button['confirm']) ? 'button confirm' : 'button';
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

<?php if ($pagination): echo $pagination['links']; endif; ?>

<?php } else { ?>

<div class="no_data">
	<?php

		if (isset($no_entries_message) and $no_entries_message) {
			echo lang_label($no_entries_message);
		} else {
			echo lang('streams:no_entries');
		}

	?>
</div><!--.no_data-->

<?php } ?>
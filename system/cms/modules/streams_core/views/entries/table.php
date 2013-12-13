<!-- .panel-body -->
<!--<div class="panel-body">-->

	<?php if (! empty($filters)): ?>
		<?php $this->load->view('streams_core/entries/filters'); ?>
	<?php endif; ?>


	<?php if ($entries->count() > 0): ?>

		<table class="table table-hover n-m">
			<thead>
				<tr>
					<?php if ($stream->sorting == 'custom'): ?><th></th><?php endif; ?>
					<?php foreach ($field_names as $field_slug=>$field_name): ?>
					<?php

						// Replace relation: from Cp voodoo
						$field_slug = str_replace('relation:', '', $field_slug);

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
									$caret = 'fa fa-caret-up';
								else
									$caret = 'fa fa-caret-down';
							else
								$caret = 'fa fa-caret-up';

						?>
						<th>
							<a href="<?php echo site_url(uri_string()).'?'.http_build_query($query_string); ?>">
								<?php echo empty($field_name) ? (substr($field_slug, 0, 5) == 'lang:' ? lang_label($field_slug) : humanize($field_slug)) : $field_name; ?>
								<?php if ($caret) echo '<b class="'.$caret.'"></b>'; ?>
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

						<?php echo $entry->getStringOutput($view_option); ?>

					</td>
					<?php endforeach; endif; ?>
					<td class="text-right">

						<?php

							if (isset($buttons)) {
								$all_buttons = array();

								foreach ($buttons as $button) {

									// The second is kept for backwards compatibility
									$url = ci()->parser->parse_string($button['url'], $entry->toArray(), true);
									$url = str_replace('-entry_id-', $entry->getKey(), $url);

									// Label
									$label = lang_label($button['label']);

									// Remove URL
									unset($button['url'], $button['label']);

									// Parse variables in attributes
									foreach ($button as $key => &$value)
										$value = ci()->parser->parse_string($value, $entry->toArray(), true);

									$all_buttons[] = anchor($url, $label, $button);
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

	    <div class="panel-footer">
			
			<?php if ($pagination) echo $pagination['links']; ?>

		</div>

	<?php else: ?>

		<div class="alert alert-info m">
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
<?php echo form_open_multipart($form_url, 'class="streams_form"'); ?>

<div class="tabs">

	<ul class="tab-menu">
	<?php foreach($tabs as $tab): ?>
		<li>
			<a href="#<?php echo $tab['id']; ?>" title="<?php echo $tab['title']; ?>">
				<span><?php echo $tab['title']; ?></span>
			</a>
		</li>
	<?php endforeach; ?>
	</ul>

	<?php foreach($tabs as $tab): ?>
	<div class="form_inputs" id="<?php echo $tab['id']; ?>">
		
		<?php if ( ! empty($tab['content']) and is_string($tab['content'])): ?>

			<?php echo $tab['content']; ?>

		<?php else: ?>
		
			<fieldset>

				<ul>

					<?php foreach ($tab['fields'] as $field) { ?>

						<?php if (isset($fields[$field])): ?>
						<li class="<?php echo in_array(str_replace($stream->stream_slug.'-'.$stream->stream_namespace.'-', '', $fields[$field]['input_slug']), $hidden) ? 'hidden' : null; ?>">
							<label for="<?php echo $fields[$field]['input_slug'];?>"><?php echo lang_label($fields[$field]['input_title']);?> <?php echo $fields[$field]['required'];?>

							<?php if( $fields[$field]['instructions'] != '' ): ?>
								<br /><small><?php echo lang_label($fields[$field]['instructions']); ?></small>
							<?php endif; ?>
							</label>

							<div class="input"><?php echo $fields[$field]['input']; ?></div>
						</li>
						<?php endif; ?>
					<?php } ?>

				</ul>

			</fieldset>
			
		<?php endif; ?>

	</div>
	<?php endforeach; ?>

</div>

	<?php if ($mode == 'edit') { ?><input type="hidden" value="<?php echo $entry->id;?>" name="row_edit_id" /><?php } ?>

	<div class="float-right buttons">
		<button type="submit" name="btnAction" value="save" class="btn green"><?php echo lang('buttons:save'); ?></button>
		
		<?php if (! empty($exit_redirect)): ?>
		<button type="submit" name="btnAction" value="save_exit" class="btn green"><?php echo lang('buttons:save_exit'); ?></button>
		<?php endif; ?>

		<?php if (! empty($create_redirect)): ?>
		<button type="submit" name="btnAction" value="save_create" class="btn green"><?php echo lang('buttons:save_create'); ?></button>
		<?php endif; ?>

		<?php if (! empty($continue_redirect)): ?>
		<button type="submit" name="btnAction" value="save_continue" class="btn green"><?php echo lang('buttons:save_continue'); ?></button>
		<?php endif; ?>

		<a href="<?php echo site_url(isset($cancel_uri) ? $cancel_uri : 'admin/streams/entries/index/'.$stream->id); ?>" class="btn gray"><?php echo lang('buttons:cancel'); ?></a>		
	</div>

<?php echo form_close();

<?php echo form_open_multipart(uri_string(), 'class="streams_form"'); ?>


	<!-- .nav-tabs -->
	<ul class="nav nav-tabs padded no-padding-bottom grayLightest-bg" data-NOT-persistent-tabs="<?php echo $stream->stream_namespace.'_'.$stream->stream_slug; ?>"> <!-- TODO: Persistent .. or not -->
		<?php foreach($tabs as $k => $tab): ?>
			<li class="<?php echo array_search($tab, array_values($tabs)) == '0' ? 'active' : null; ?>">
				<a href="#<?php echo $tab['id']; ?>" data-toggle="tab">
					<span><?php echo lang_label($tab['title']); ?></span>
				</a>
			</li>
		<?php endforeach; ?>
	</ul>


	<!-- .tab-content -->
	<div class="tab-content">
		
		<?php foreach($tabs as $tab): ?>
		<div class="tab-pane <?php echo array_search($tab, array_values($tabs)) == '0' ? 'active' : null; ?>" id="<?php echo $tab['id']; ?>">
			<fieldset>

				<ul>

				<?php foreach( $tab['fields'] as $field ): ?>

					<li class="row-fluid input-row streams-field-<?php echo $field; ?> streams-field-type-<?php echo $fields[$field]['field_type']; ?> <?php echo in_array($fields[$field]['input_slug'], $hidden) ? 'hidden' : null; ?>">
						<label class="span3" for="<?php echo $fields[$field]['input_slug'];?>"><?php echo $this->fields->translate_label($fields[$field]['input_title']);?> <?php echo $fields[$field]['required'];?>
						
						<?php if (isset($fields[$field]['instructions']) and $fields[$field]['instructions'] != ''): ?>
							<small><?php echo $this->fields->translate_label($fields[$field]['instructions']); ?></small>
						<?php endif; ?>
						</label>
						
						<div class="input span9"><?php echo $fields[$field]['input']; ?></div>
					</li>

				<?php endforeach; ?>
				
				</ul>

			</fieldset>

		</div>
		<?php endforeach; ?>

	</div>


	<?php if ($mode == 'edit'){ ?><input type="hidden" value="<?php echo $entry->id;?>" name="row_edit_id" /><?php } ?>

	<div class="btn-group padded">
		<button type="submit" name="btnAction" value="save" class="btn blue"><span><?php echo lang('buttons:save'); ?></span></button>	
		<?php if (isset($cancel_uri)): ?>
			<a href="<?php echo site_url($cancel_uri); ?>" class="btn"><?php echo lang('buttons:cancel'); ?></a>
		<?php else: ?>
			<a href="<?php echo site_url(isset($return) ? $return : 'admin/streams/entries/index/'.$stream->id); ?>" class="btn"><?php echo lang('buttons:cancel'); ?></a>
		<?php endif; ?>
	</div>


<?php echo form_close();?>
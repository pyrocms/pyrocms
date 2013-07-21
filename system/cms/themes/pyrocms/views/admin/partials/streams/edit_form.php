<?php if (! empty($tabs)): ?>

<!-- Form Editor Wrapper -->
<div class="form-editor-wrapper dd" data-form="<?php echo $form->id; ?>" data-stream="<?php echo $stream->id; ?>">
	
	<ul class="nav nav-tabs sortable padded no-padding-bottom grayLightest-bg" data-persistent-tabs="true">

		<?php foreach ($tabs as $k => $tab): ?>
		<li class="<?php echo $k == '0' ? 'active' : null; ?> tab" data-tab="<?php echo $tab['id']; ?>">
			<a href="#<?php echo $tab['slug']; ?>" data-toggle="tab">
				<span><?php echo lang_label($tab['title']); ?></span>
			</a>
		</li>
		<?php endforeach; ?>

		<li>
			<a href="#add-<?php echo $stream->stream_slug; ?>-tab" data-toggle="modal">
				<?php echo lang('global:add'); ?> <i class="icon-plus-sign"></i>
			</a>
		</li>

	</ul>


	<div class="tab-content padded no-padding-top">

		<?php foreach ($tabs as $k=>$tab): ?>
		<div class="tab-pane dd <?php echo $k == '0' ? 'active' : null; ?>" id="<?php echo $tab['slug']; ?>" data-tab="<?php echo $tab['id']; ?>">
			
			<ul class="dd-list tab-stream_fields">
				<?php foreach ($tab['fields'] as $k=>$field_slug): ?>
				<?php foreach ($stream_fields as $stream_field): ?>
				<?php if ($stream_field->field_slug != $field_slug) continue; ?>

					<li class="dd-item" data-field="<?php echo $stream_field->assign_id; ?>">
						<div class="dd-handle dd3-handle"></div>
						<div class="dd3-content">
							<?php echo '<strong>'.lang_label($stream_field->field_name).'</strong>'.' | '.lang_label($stream_field->instructions); ?>

							<a href="<?php echo site_url('streams_core/forms/delete_tab_stream_field/'.$tab['id'].'/'.$stream_field->assign_id); ?>"><i class="icon-trash"></i></a>
						</div>
					</li>

				<?php endforeach; ?>
				<?php endforeach; ?>
			</ul>

			<div class="btn-group margin-top">
				<a href="#add-<?php echo $stream->stream_slug; ?>-tab-stream_field-<?php echo $tab['id']; ?>" data-toggle="modal" class="btn btn-small">Add Field</a>
				<a href="#edit-<?php echo $stream->stream_slug; ?>-tab-<?php echo $tab['id']; ?>" data-toggle="modal" class="btn btn-small"><?php echo lang('global:edit'); ?></a>
				<a href="<?php echo site_url('streams_core/forms/delete_tab/'.$tab['id']); ?>" class="btn btn-small btn-danger confirm"><?php echo lang('global:delete'); ?></a>
			</div>

			<!-- Modal -->
			<div class="hide modal fade" id="edit-<?php echo $stream->stream_slug; ?>-tab-<?php echo $tab['id']; ?>" tabindex="-1" role="dialog">
				<?php echo form_open(site_url('streams_core/forms/edit_tab/'.$tab['id']), 'class="no-margin"'); ?>

					<!-- Our Header -->
					<div class="modal-header">

						<button type="button" class="close" data-dismiss="modal">×</button>
						
						<h3>Edit Tab</h3>

					</div>

					
					<!-- Body Content -->
					<div class="modal-body padding-top">

						<fieldset>
							<ul>

								<li class="row-fluid input-row">
									<label class="span3" for="field_name">Title <span>*</span></label>
									<div class="input span9">
										<input type="text" name="title" value="<?php echo $tab['title']; ?>"/>
									</div>
								</li>

							</ul>
						</fieldset>

					</div>
					

					<!-- Modal Footer -->
					<div class="modal-footer">
						<button class="btn btn-primary">Save</button>
					</div>

				<?php echo form_close(); ?>
			</div>


			<!-- Modal -->
			<div class="hide modal fade" id="add-<?php echo $stream->stream_slug; ?>-tab-stream_field-<?php echo $tab['id']; ?>" tabindex="-1" role="dialog">
				
					<!-- Our Header -->
					<div class="modal-header">

						<button type="button" class="close" data-dismiss="modal">×</button>
						
						<h3>Add Field</h3>

					</div>

					
					<!-- Body Content -->
					<div class="modal-body padded dd">

						<?php if (! empty($available_stream_fields)): ?>
						<ul class="dd-list">
						<?php foreach ($available_stream_fields as $assign_id => $available_stream_field): ?>
						<li class="dd-item">

							<?php foreach ($stream_fields as $stream_field): ?>
							<?php if ($assign_id != $stream_field->assign_id) continue; ?>
								<a href="<?php echo site_url('streams_core/forms/add_tab_stream_field/'.$tab['id'].'/'.$assign_id); ?>" class="dd-handle-dummy">
									<strong><?php echo lang_label($stream_field->field_name); ?></strong> | <small><?php echo lang_label($stream_field->instructions); ?></small>
								</a>
							<?php endforeach; ?>
						</li>
						<?php endforeach; ?>
						</ul>
						<?php else: ?>
							<div class="alert margin"><?php echo lang('streams:no_results'); ?></div>
						<?php endif; ?>

					</div>
					
			</div>

		</div>
		<?php endforeach; ?>


		<!-- Modal -->
		<div class="hide modal fade" id="add-<?php echo $stream->stream_slug; ?>-tab" tabindex="-1" role="dialog">
			
			<?php echo form_open(site_url('streams_core/forms/add_tab/'.$stream->id.'/'.$form->id), 'class="no-margin"'); ?>

				<!-- Our Header -->
				<div class="modal-header">

					<button type="button" class="close" data-dismiss="modal">×</button>
					
					<h3>Add Tab</h3>

				</div>

				
				<!-- Body Content -->
				<div class="modal-body padding-top">

					<fieldset>
						<ul>

							<li class="row-fluid input-row">
								<label class="span3" for="field_name">Title <span>*</span></label>
								<div class="input span9">
									<input type="text" name="title"/>
								</div>
							</li>

						</ul>
					</fieldset>

				</div>
				

				<!-- Modal Footer -->
				<div class="modal-footer">
					<button class="btn btn-primary">Save</button>
				</div>

			<?php echo form_close(); ?>

		</div>
		<!-- /Modal -->

	</div>

</div>

<?php else: ?>
	<div class="alert margin"><?php echo lang('streams:no_results'); ?></div>
<?php endif; ?>
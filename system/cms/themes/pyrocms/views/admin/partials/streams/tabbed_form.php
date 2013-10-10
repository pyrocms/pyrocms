

		<?php echo form_open_multipart($form_url, 'class="streams_form"'); ?>

		<div class="tabs">

			<ul class="nav nav-tabs">
			<?php foreach($tabs as $tab): ?>
				<li class="<?php echo array_search($tab, $tabs) == 0 ? 'active' : null; ?>">
					<a href="#<?php echo $tab['id']; ?>" data-toggle="tab" title="<?php echo $tab['title']; ?>">
						<span><?php echo $tab['title']; ?></span>
					</a>
				</li>
			<?php endforeach; ?>
			</ul>

			<div class="tab-content panel">
			<?php foreach($tabs as $tab): ?>
				<div class="tab-pane <?php echo array_search($tab, $tabs) == 0 ? 'active' : null; ?>" id="<?php echo $tab['id']; ?>">
					
					<?php if ( ! empty($tab['content']) and is_string($tab['content'])): ?>

						<?php echo $tab['content']; ?>

					<?php else: ?>
					
						<fieldset>

							<ul>

								<?php foreach ($tab['fields'] as $field) { ?>

									<li class="<?php echo in_array($fields[$field]['input_slug'], $hidden) ? 'hidden' : null; ?>">
										<label for="<?php echo $fields[$field]['input_slug'];?>"><?php echo lang_label($fields[$field]['input_title']);?> <?php echo $fields[$field]['required'];?>

										<?php if( $fields[$field]['instructions'] != '' ): ?>
											<br /><small><?php echo lang_label($fields[$field]['instructions']); ?></small>
										<?php endif; ?>
										</label>

										<div class="input"><?php echo $fields[$field]['input']; ?></div>
									</li>

								<?php } ?>

							</ul>

						</fieldset>
						
					<?php endif; ?>

				</div>
			<?php endforeach; ?>
			</div>

		</div>

		<?php if ($mode == 'edit') { ?><input type="hidden" value="<?php echo $entry->id;?>" name="row_edit_id" /><?php } ?>

		<div class="panel-footer">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel'))) ?>
		</div>

		<?php echo form_close(); ?>

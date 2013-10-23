<?php echo form_open_multipart($form_url, 'class="streams_form"'); ?>

	
	<!-- .nav.nav-tabs -->
	<ul class="nav nav-tabs">
	<?php foreach($tabs as $tab): ?>

		<li class="<?php echo array_search($tab, $tabs) == 0 ? 'active' : null; ?>">
		
			<a href="#<?php echo $tab['id']; ?>" data-toggle="tab" title="<?php echo $tab['title']; ?>">
				<span><?php echo $tab['title']; ?></span>
			</a>

		</li>

	<?php endforeach; ?>
	</ul>
	<!-- /.nav.nav-tabs -->


	<!-- .tab-content.panel-body -->
	<section class="tab-content panel-body">

		<?php foreach($tabs as $tab): ?>

			<div class="tab-pane <?php echo array_search($tab, $tabs) == 0 ? 'active' : null; ?>" id="<?php echo $tab['id']; ?>">
				
				<?php if ( ! empty($tab['content']) and is_string($tab['content'])): ?>

					<?php echo $tab['content']; ?>

				<?php else: ?>

					<?php foreach ($tab['fields'] as $field): ?>

						<div class="form-group <?php echo in_array(str_replace($stream->stream_namespace.'-'.$stream->stream_slug.'-', '', $fields[$field]['input_slug']), $hidden) ? 'hidden' : null; ?>">
						<div class="row">
							
							<label class="col-lg-2 control-label" for="<?php echo $fields[$field]['input_slug'];?>">
								<?php echo lang_label($fields[$field]['input_title']);?> <?php echo $fields[$field]['required'];?>

								<?php if( $fields[$field]['instructions'] != '' ): ?>
									<p class="help-block c-gray-light">This is an example<?php echo lang_label($fields[$field]['instructions']); ?></p>
								<?php endif; ?>
							</label>

							<div  class="col-lg-10">
								<?php echo $fields[$field]['input']; ?>
							</div>

						</div>
						</div>

					<?php endforeach; ?>
					
				<?php endif; ?>

			</div>

		<?php endforeach; ?>

	</section>
	<!-- /.tab-content.panel-body -->


	<?php if ($mode == 'edit'): ?>
		<input type="hidden" value="<?php echo $entry->id;?>" name="row_edit_id" />
	<?php endif; ?>

	<div class="panel-footer">
		<button type="submit" name="btnAction" value="save" class="btn btn-success"><?php echo lang('buttons:save'); ?></button>
		<button type="submit" name="btnAction" value="save_exit" class="btn btn-success"><?php echo lang('buttons:save_exit'); ?></button>
		<a href="<?php echo site_url(isset($redirect) ? $redirect : 'admin/streams/entries/index/'.$stream->id); ?>" class="btn btn-default"><?php echo lang('buttons:cancel'); ?></a>		
	</div>


<?php echo form_close(); ?>
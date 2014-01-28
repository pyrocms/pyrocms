<?php if (!$formOverride): ?>
<?php echo form_open_multipart($formUrl, 'class="streams_form"'); ?>
<?php endif; ?>

	
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

					<?php foreach ($tab['fields'] as $slug): ?>

						<?php if ($field = $fields->findBySlug($slug)): ?>
						<div class="form-group <?php echo in_array($field->field_slug, $hidden) ? 'hidden' : null; ?>">
						<div class="row">
							
							<?php echo $field->input_row; ?>

						</div>
						</div>
						<?php endif; ?>

					<?php endforeach; ?>
					
				<?php endif; ?>

			</div>

		<?php endforeach; ?>

	</section>
	<!-- /.tab-content.panel-body -->


	<?php if ($mode == 'edit'): ?>
		<input type="hidden" value="<?php echo $entry->id;?>" name="row_edit_id" />
	<?php endif; ?>


	<?php if (!$formOverride): ?>
	<div class="panel-footer">
		<button type="submit" name="btnAction" value="save" class="btn btn-success"><?php echo lang('buttons:save'); ?></button>
		
		<?php if (! empty($exitRedirect)): ?>
		<button type="submit" name="btnAction" value="save_exit" class="btn btn-success"><?php echo lang('buttons:save_exit'); ?></button>
		<?php endif; ?>

		<?php if (! empty($createRedirect)): ?>
		<button type="submit" name="btnAction" value="save_create" class="btn btn-info"><?php echo lang('buttons:save_create'); ?></button>
		<?php endif; ?>

		<?php if (! empty($continueRedirect)): ?>
		<button type="submit" name="btnAction" value="save_continue" class="btn btn-info"><?php echo lang('buttons:save_continue'); ?></button>
		<?php endif; ?>

		<a href="<?php echo site_url(isset($cancel_uri) ? $cancel_uri : $redirectSave); ?>" class="btn btn-default"><?php echo lang('buttons:cancel'); ?></a>		
	</div>
	<?php endif; ?>


<?php if (!$formOverride): ?>
<?php echo form_close(); ?>
<?php endif; ?>

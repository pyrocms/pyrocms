<h3><?php echo lang('gallery_images.edit_image_label'); ?></h3>

<?php echo form_open($this->uri->uri_string(), 'class="crud"'); ?>
	<ul>
		<li class="<?php echo alternator('', 'even'); ?>">
			<label for="current_thumbnail"><?php echo lang('gallery_images.thumbnail_label'); ?></label>
			<img id="current_thumbnail" src="<?php echo BASE_URL.'uploads/galleries/' . $gallery_image->slug . '/thumbs/' . $gallery_image->filename . '_thumb' . $gallery_image->extension; ?>" alt="<?php echo $gallery_image->title; ?>" />
			<input type="hidden" id="thumb_width" name="thumb_width" />
			<input type="hidden" id="thumb_height" name="thumb_height" />
			<input type="hidden" id="thumb_x" name="thumb_x" />
			<input type="hidden" id="thumb_y" name="thumb_y" />
			<input type="hidden" id="scaled_height" name="scaled_height" />
			<br />
			<label for="crop-button"></label>
			<a class="colorbox button" name="crop-button" href="<?php echo BASE_URL.'uploads/galleries/' . $gallery_image->slug . '/full/' . $gallery_image->filename . $gallery_image->extension; ?>"><?php echo lang('gallery_images.crop_label'); ?></a>
			<br />
			<br />
			<span class="crop_options" style="display:none;">
				<label for="apply_to"><?php echo lang('gallery_images.options_label'); ?></label>
				<?php echo form_checkbox('ratio', '1', TRUE); ?><span  class="crop_checkbox"><?php echo lang('gallery_images.ratio_label').'<br /><strong>'.lang('gallery_images.crop.save_label'); ?></strong></span>
			</span>
		</li>
		<li class="<?php echo alternator('', 'even'); ?>">
			<label for="title"><?php echo lang('gallery_images.title_label'); ?></label>
			<input type="text" id="title" name="title" maxlength="255" value="<?php echo $gallery_image->title; ?>" />
		</li>
		<li class="<?php echo alternator('', 'even'); ?>">
			<label for="description"><?php echo lang('gallery_images.description_label'); ?></label>
			<textarea id="description" name="description" rows="3" col="20"><?php echo $gallery_image->description; ?></textarea>
		</li>
		<li class="<?php echo alternator('', 'even'); ?>">
			<label for="delete"><?php echo lang('gallery_images.delete_label'); ?></label>
			<?php echo form_checkbox('delete', '1', FALSE); ?>
		</li>
	</ul>

	<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
<?php echo form_close(); ?>

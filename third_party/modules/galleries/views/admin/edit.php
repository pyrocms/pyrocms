<div class="box" id="galleries_image_box">
	<h3>Edit Image</h3>
	
	<div class="box-container">
		<?php echo form_open($this->uri->uri_string(), 'class="crud"'); ?>
			<ol>
				<li class="even">
					<label for="current_thumbnail">Thumbnail</label>
					<img id="current_thumbnail" src="<?php echo site_url('uploads/galleries/' . $gallery_image->slug . '/thumbs/' . $gallery_image->filename . '_thumb.' . $gallery_image->extension); ?>" alt="<?php echo $gallery_image->title; ?>" />
					<input type="hidden" id="thumb_width" name="thumb_width" />
					<input type="hidden" id="thumb_height" name="thumb_height" />
					<input type="hidden" id="thumb_x" name="thumb_x" />
					<input type="hidden" id="thumb_y" name="thumb_y" />
				</li>
				<li>
					<label for="thumbnail_actions">Actions</label>
					<select id="thumbnail_actions" name="thumbnail_actions">
						<option value="NONE" selected="selected">-- NONE --</option>
						<option value="crop">Crop thumbnail</option>
						<option value="new">Recreate thumbnail</option>
						<option value="delete">Delete Image</option>
					</select>
				</li>
				<li class="even">
					<label for="title">Title</label>
					<input type="text" id="title" name="title" maxlength="255" value="<?php echo $gallery_image->title; ?>" />
					<!-- <span class="required-icon tooltip">Required</span> -->
				</li>
				<li>
					<label for="description">Description</label>
					<textarea id="description" name="description" rows="10"><?php echo $gallery_image->description; ?></textarea>
				</li>
			</ol>
			
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		<?php echo form_close(); ?>
	</div>
</div>
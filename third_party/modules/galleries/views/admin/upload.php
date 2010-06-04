<div class="box" id="galleries_upload_box">
	<h3>Upload Image</h3>
	
	<div class="box-container">
		<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
			<ol>
				<li>
					<label for="title">Title</label>
					<input type="text" id="title" name="title" maxlength="255" value="<?php echo $gallery_image->title; ?>" />
					<!-- <span class="required-icon tooltip">Required</span> -->
				</li>
				<li class="even">
					<label for="userfile">Image</label>
					<input type="file" name="userfile" id="userfile" />
				</li>
				<li>
					<label for="gallery_id">Gallery</label>
					<select id="gallery_id" name="gallery_id">
						<?php foreach ( $galleries as $gallery ): ?>
						<option value="<?php echo $gallery->id; ?>"><?php echo $gallery->title; ?></option>
						<?php endforeach; ?>
					</select>
				</li>
				<li class="even">
					<label for="description">Description</label>
					<textarea id="description" name="description" rows="10"><?php echo $gallery_image->description; ?></textarea>
				</li>
			</ol>
			
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		<?php echo form_close(); ?>
	</div>
</div>
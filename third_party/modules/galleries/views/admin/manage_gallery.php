<div class="box" id="galleries_form_box">

	<h3>Manage Gallery</h3>
	
	<div class="box-container">
		<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
			<ol>
				<li>
					<label for="title">Title</label>
					<input type="text" id="title" name="title" maxlength="255" value="<?php echo $gallery->title; ?>" />
					<span class="required-icon tooltip">Required</span>
				</li>
				
				<li class="even">
					<label for="slug">Slug</label>
					<?php echo form_input('slug', $gallery->slug, 'class="width-15"'); ?>
					<span class="required-icon tooltip">Required</span>
				</li>
				
				<li>
					<label for="parent">Parent</label>		
					<select name="parent" id="parent">
						<!-- Available galleries -->
						<option value="NONE">-- NONE --</option>
						<?php if ( !empty($galleries) ): foreach ( $galleries as $available_gallery ): if ($available_gallery->id != $gallery->id): ?>
						<option value="<?php echo $available_gallery->id; ?>" <?php if ($available_gallery->id == $gallery->parent) {echo ' selected="selected" ';} ?> >
							<?php echo $available_gallery->title; ?>
						</option>
						<?php endif; endforeach; endif; ?>
					</select>
				</li>
				
				<li class="even">
					<label for="description">Description</label>
					<?php echo form_textarea(array('id'=>'description', 'name'=>'description', 'value' => $gallery->description, 'rows' => 10, 'class' => 'wysiwyg-simple')); ?>
				</li>
				
				<?php if ( !empty($gallery_images) ): ?>
				<li>
					<label for="gallery_thumbnail">Thumbnail</label>
					<select name="gallery_thumbnail" id="gallery_thumbnail">
						
						<?php if ( !empty($gallery->thumbnail_id) ): ?>
						<!-- Current thumbnail -->
						<optgroup label="Current">
							<?php foreach ( $gallery_images as $image ): if ( $image->id == $gallery->thumbnail_id ): ?>
							<option value="<?php echo $gallery->thumbnail_id; ?>">
								<?php echo $image->title; ?>
							</option>
							<?php break; endif; endforeach; ?>
						</optgroup>
						<?php endif; ?>
						
						<!-- Available thumbnails -->
						<optgroup label="Thumbnails">
							<?php foreach ( $gallery_images as $image ): ?>
							<option value="<?php echo $image->id; ?>">
								<?php echo $image->title; ?>
							</option>
							<?php endforeach; ?>
						</optgroup>
						
					</select>
				</li>
				<li class="even">
					<label for="gallery_images">Current Images</label>
					<ul id="gallery_images_list">
						<?php if ( $gallery_images !== FALSE ): ?>
						<?php foreach ( $gallery_images as $image ): ?>
						<li>
							<a href="<?php echo site_url('admin/galleries/edit_image/' . $image->id); ?>" title="<?php echo "File: " . $image->filename . '.' . $image->extension . "\nTitle: " . $image->title; ?>">
								<img src="<?php echo site_url('uploads/galleries/' . $image->slug . '/thumbs/' . $image->filename . '_thumb.' . $image->extension);?>" alt="<?php echo $image->title; ?>" />
							</a>
						</li>
						<?php endforeach; ?>
						<?php else: ?>
						<li>
							No images have been added yet
						</li>
						<?php endif; ?>
					</ul>
					<div class="clear-both"></div>
				</li>	
				<?php endif; ?>
			</ol>
			
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		<?php echo form_close(); ?>
	</div>
</div>
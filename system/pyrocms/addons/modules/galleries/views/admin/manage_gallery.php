<div id="galleries_form_box">
	<h3><?php echo lang('galleries.manage_gallery_label'); ?></h3>

	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
		<ol>
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="title"><?php echo lang('galleries.title_label'); ?></label>
				<input type="text" id="title" name="title" maxlength="255" value="<?php echo $gallery->title; ?>" />
				<span class="required-icon tooltip">Required</span>
			</li>

			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="slug"><?php echo lang('galleries.slug_label'); ?></label>
				<?php echo form_input('slug', $gallery->slug, 'class="width-15"'); ?>
				<span class="required-icon tooltip">Required</span>
			</li>

			<?php if (!empty($galleries[1])): ?>
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="parent_id"><?php echo lang('galleries.parent_label'); ?></label>
				<select name="parent_id" id="parent">
					<!-- Available galleries -->
					<option value="0"><?php echo lang('galleries.none_label'); ?></option>
					<?php if ( !empty($galleries) ): foreach ( $galleries as $available_gallery ): if ($available_gallery->id != $gallery->id): ?>
					<option value="<?php echo $available_gallery->id; ?>" <?php if ($available_gallery->id == $gallery->parent) {echo ' selected="selected" ';} ?> >
						<?php echo $available_gallery->title; ?>
					</option>
					<?php endif; endforeach; endif; ?>
				</select>
			</li>
			<?php endif; ?>

			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="description"><?php echo lang('galleries.description_label'); ?></label>
				<?php echo form_textarea(array('id'=>'description', 'name'=>'description', 'value' => $gallery->description, 'rows' => 10, 'class' => 'wysiwyg-simple')); ?>
			</li>

			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="comments"><?php echo lang('galleries.comments_label'); ?></label>
				<?php echo form_dropdown('enable_comments', array('1'=>lang('galleries.comments_enabled_label'), '0'=>lang('galleries.comments_disabled_label')), $gallery->enable_comments); ?>
			</li>

			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="published"><?php echo lang('galleries.published_label'); ?></label>
				<?php echo form_dropdown('published', array('1'=>lang('galleries.published_yes_label'), '0'=>lang('galleries.published_no_label')), $gallery->published); ?>
			</li>

			<?php if ( !empty($gallery_images) ): ?>
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="gallery_thumbnail"><?php echo lang('galleries.thumbnail_label'); ?></label>
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
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="gallery_images"><?php echo lang('galleries.current_label'); ?></label>
				<div class="clear-both"></div>
				<ul id="gallery_images_list">
					<?php if ( $gallery_images !== FALSE ): ?>
					<?php foreach ( $gallery_images as $image ): ?>
					<li>
						<?php echo anchor('admin/galleries/edit_image/' . $image->id,
								  img(array('src' => BASE_URL . 'uploads/galleries/' . $gallery->slug . '/thumbs/' . $image->filename . '_thumb' . $image->extension, 'alt' => $image->title, 'title' => 'File: ' . $image->filename . $image->extension . ' Title: ' . $image->title))); ?>
							<?php echo form_hidden('action_to[]', $image->id); ?>
					</li>
					<?php endforeach; ?>
					<?php else: ?>
					<li>
						<?php echo lang('gallery_images.no_images_label'); ?>
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

<?php if ($this->method === 'create'): ?>
<h3><?php echo lang('galleries.new_gallery_label'); ?></h3>
<?php else: ?>
<h3><?php echo sprintf(lang('galleries.manage_gallery_label'), $gallery->title); ?></h3>
<?php endif; ?>

<?php echo form_open(uri_string(), 'class="crud"', array('folder_id' => $gallery->folder_id)); ?>

	<div class="tabs">

		<ul class="tab-menu">
			<li><a href="#gallery-content"><span><?php echo lang('galleries.content_label'); ?></span></a></li>
			<li><a href="#gallery-design"><span><?php echo lang('galleries.design_label'); ?></span></a></li>
			<li><a href="#gallery-script"><span><?php echo lang('galleries.script_label'); ?></span></a></li>
		</ul>

		<div id="gallery-content">
			<ol>
				<li class="<?php echo alternator('', 'even'); ?>">
					<?php echo form_label(lang('galleries.folder_label'), 'folder_id'); ?>
					<?php echo form_dropdown('folder_id', array(lang('select.pick')) + $folders_tree, $gallery->folder_id, 'id="folder_id" class="required"'); ?>
				</li>

				<li class="<?php echo alternator('', 'even'); ?>">
					<label for="title"><?php echo lang('galleries.title_label'); ?></label>
					<input type="text" id="title" name="title" maxlength="255" value="<?php echo $gallery->title; ?>" />
					<span class="required-icon tooltip"><?php echo lang('required_label'); ?></span>
				</li>

				<li class="<?php echo alternator('', 'even'); ?>">
					<label for="slug"><?php echo lang('galleries.slug_label'); ?></label>
					<?php echo form_input('slug', $gallery->slug, 'class="width-15"'); ?>
					<span class="required-icon tooltip"><?php echo lang('required_label'); ?></span>
				</li>

				<li class="<?php echo alternator('', 'even'); ?>">
					<label for="description"><?php echo lang('galleries.description_label'); ?></label><br />
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

				<li class="thumbnail-manage <?php echo alternator('', 'even'); ?>">
					<label for="gallery_thumbnail"><?php echo lang('galleries.thumbnail_label'); ?></label>
					<select name="gallery_thumbnail" id="gallery_thumbnail">

						<?php if ( ! empty($gallery->thumbnail_id) ): ?>
						<!-- Current thumbnail -->
						<optgroup label="Current">
							<?php foreach ( $gallery_images as $image ): if ( $image->file_id == $gallery->thumbnail_id ): ?>
							<option value="<?php echo $gallery->thumbnail_id; ?>">
								<?php echo $image->name; ?>
							</option>
							<?php break; endif; endforeach; ?>
						</optgroup>
						<?php endif; ?>

						<!-- Available thumbnails -->
						<optgroup label="Thumbnails">
							<option value="0"><?php echo lang('galleries.no_thumb_label'); ?></option>
							<?php foreach ( $gallery_images as $image ): ?>
							<option value="<?php echo $image->file_id; ?>">
								<?php echo $image->name; ?>
							</option>
							<?php endforeach; ?>
						</optgroup>

					</select>
				</li>
				
				<?php if (isset($gallery_images) && $gallery_images): ?>
				<li class="images-manage <?php echo alternator('', 'even'); ?>">
					<label for="gallery_images"><?php echo lang('galleries.current_label'); ?></label>
					<div class="clear-both"></div>
					<ul id="gallery_images_list">
						<?php if ( $gallery_images !== FALSE ): ?>
						<?php foreach ( $gallery_images as $image ): ?>
						<li>
							<a href="<?php echo site_url() . 'admin/files/edit/' . $image->file_id; ?>" class="modal">
								<?php echo img(array('src' => site_url() . 'files/thumb/' . $image->file_id, 'alt' => $image->name, 'title' => 'Title: ' . $image->name . ' -- Caption: ' . $image->description)); ?>
								<?php echo form_hidden('action_to[]', $image->id); ?>
							</a>
						</li>
						<?php endforeach; ?>
						<?php endif; ?>
					</ul>
					<div class="clear-both"></div>
				</li>
				<?php endif; ?>
				
				<li style="display: none;" class="images-placeholder <?php echo alternator('', 'even'); ?>">
					<label for="gallery_images"><?php echo lang('galleries.preview_label'); ?></label>
					<div class="clear-both"></div>
					<ul id="gallery_images_list">

					</ul>
					<div class="clear-both"></div>
				</li>

			</ol>

		</div>

		<!-- Design tab -->
		<div id="gallery-design">

			<ol>
				<li>
					<label for="css"><?php echo lang('galleries.css_label'); ?></label>
					<div style="margin-left: 160px;">
						<?php echo form_textarea('css', $gallery->css, 'id="css_editor"'); ?>
					</div>
				</li>
			</ol>

			<br class="clear-both" />

		</div>

		<!-- Script tab -->
		<div id="gallery-script">

			<ol>
				<li>
					<label for="js"><?php echo lang('galleries.js_label'); ?></label>
					<div style="margin-left: 160px;">
						<?php echo form_textarea('js', $gallery->js, 'id="js_editor"'); ?>
					</div>
				</li>
			</ol>

			<br class="clear-both" />

		</div>

	</div>

	<div class="buttons align-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel') )); ?>
	</div>

<?php echo form_close(); ?>

<script type="text/javascript">
css_editor('css_editor', '100%');
js_editor('js_editor', '100%');
</script>
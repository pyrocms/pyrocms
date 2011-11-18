<section class="title">
	<?php if ($this->method === 'create'): ?>
	<h4><?php echo lang('galleries.new_gallery_label'); ?></h4>
	<?php else: ?>
	<h4><?php echo sprintf(lang('galleries.manage_gallery_label'), $gallery->title); ?></h4>
	<?php endif; ?>
</section>

<section class="item">
	
	<?php echo form_open(uri_string(), 'class="crud"', array('folder_id' => $gallery->folder_id)); ?>
	
		<div class="tabs">
	
			<ul class="tab-menu">
				<li><a href="#gallery-content"><span><?php echo lang('galleries.content_label'); ?></span></a></li>
				<li><a href="#gallery-design"><span><?php echo lang('galleries.design_label'); ?></span></a></li>
				<li><a href="#gallery-script"><span><?php echo lang('galleries.script_label'); ?></span></a></li>
			</ul>
			
			<div class="form_inputs" id="gallery-content">
			
			<fieldset>
			
				<ul>
					<li class="<?php echo alternator('', 'even'); ?>">
						<label for="folder_id"><?php echo lang('galleries.folder_label'); ?> <span>*</span></label>
						<div class="input"><?php echo form_dropdown('folder_id', array(lang('global:select-pick')) + $folders_tree, $gallery->folder_id, 'id="folder_id" class="required"'); ?></div>
					</li>
						
					<li class="<?php echo alternator('', 'even'); ?>">
						<label for="title"><?php echo lang('galleries.title_label'); ?> <span>*</span></label>
						<div class="input"><input type="text" id="title" name="title" maxlength="255" value="<?php echo $gallery->title; ?>" /></div>
					</li>
					
					<li class="<?php echo alternator('', 'even'); ?>">
						<label for="slug"><?php echo lang('galleries.slug_label'); ?> <span>*</span></label>
						<div class="input"><?php echo form_input('slug', $gallery->slug, 'class="width-15"'); ?></div>
					</li>
						
					<li class="<?php echo alternator('', 'even'); ?>">
						<label for="description"><?php echo lang('galleries.description_label'); ?></label><br />
						<?php echo form_textarea(array('id'=>'description', 'name'=>'description', 'value' => $gallery->description, 'rows' => 10, 'class' => 'wysiwyg-simple')); ?>
					</li>
					
					<li class="<?php echo alternator('', 'even'); ?>">
						<label for="comments"><?php echo lang('galleries.comments_label'); ?></label>
						<div class="input"><?php echo form_dropdown('enable_comments', array('1'=>lang('galleries.comments_enabled_label'), '0'=>lang('galleries.comments_disabled_label')), $gallery->enable_comments); ?></div>
					</li>
	
					<li class="<?php echo alternator('', 'even'); ?>">
						<label for="published"><?php echo lang('galleries.published_label'); ?></label>
						<div class="input"><?php echo form_dropdown('published', array('1'=>lang('galleries.published_yes_label'), '0'=>lang('galleries.published_no_label')), $gallery->published); ?></div>
					</li>
	
					<li class="thumbnail-manage <?php echo alternator('', 'even'); ?>">
						<label for="gallery_thumbnail"><?php echo lang('galleries.thumbnail_label'); ?></label>
						<div class="input"><select name="gallery_thumbnail" id="gallery_thumbnail">
	
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
	
						</select></div>
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
	
				</ul>
				</fieldset>
	
			</div>
	
			<!-- Design tab -->
			<div class="form_inputs" id="gallery-design">
	
				<fieldset>
				<ul>
					<li>
						<label for="css"><?php echo lang('galleries.css_label'); ?></label><br>
						<div>
							<?php echo form_textarea('css', $gallery->css, 'class="css_editor"'); ?>
						</div>
					</li>
				<ul>
				</fieldset>
	
			</div>
	
			<!-- Script tab -->
			<div class="form_inputs" id="gallery-script">
	
				<fieldset>
				<ul>
					<li>
						<label for="js"><?php echo lang('galleries.js_label'); ?></label><br>
						<div>
							<?php echo form_textarea('js', $gallery->js, 'class="js_editor"'); ?>
						</div>
					</li>
				</ul>
	
				</fieldset>
	
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
</section>
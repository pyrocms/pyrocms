<div id="galleries_form_box">

	<h3><?php echo lang('galleries.new_gallery_label'); ?></h3>

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

			<?php if ( ! empty($galleries) ): ?>
			<li>
				<label for="parent_id"><?php echo lang('galleries.parent_label'); ?></label>
				<select name="parent_id" id="parent" size="1">
					<option value="0"><?php echo lang('select.none'); ?></option>
					<?php foreach ( $galleries as $available_gallery ): ?>
					<option value="<?php echo $available_gallery->id; ?>"><?php echo $available_gallery->title; ?></option>
					<?php endforeach; ?>
				</select>
			</li>
			<?php endif; ?>

			<li  class="<?php echo alternator('', 'even'); ?> description">
				<label for="description"><?php echo lang('galleries.description_label'); ?></label>
				<?php echo form_textarea(array('id'=>'description', 'name'=>'description', 'value' => $gallery->description, 'rows' => 10, 'class' => 'wysiwyg-simple')); ?>
			</li>

			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="comments"><?php echo lang('galleries.comments_label'); ?></label>
				<?php echo form_dropdown('enable_comments', array('1'=>lang('galleries.comments_enabled_label'), '0'=>lang('galleries.comments_disabled_label')), '0'); ?>
			</li>

			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="published"><?php echo lang('galleries.published_label'); ?></label>
				<?php echo form_dropdown('published', array('1'=>lang('galleries.published_yes_label'), '0'=>lang('galleries.published_no_label')), 1); ?>
			</li>
		</ol>

		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
	
	<?php echo form_close(); ?>

</div>

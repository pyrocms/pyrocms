<div class="box" id="galleries_form_box">
	<h3><?php echo lang('galleries.new_gallery_label'); ?></h3>
	<div class="box-container">
		<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
			<ol>
				<li>
					<label for="title"><?php echo lang('galleries.title_label'); ?></label>
					<input type="text" id="title" name="title" maxlength="255" value="<?php echo $gallery->title; ?>" />
					<span class="required-icon tooltip">Required</span>
				</li>
				
				<li class="even">
					<label for="slug"><?php echo lang('galleries.slug_label'); ?></label>
					<?php echo form_input('slug', $gallery->slug, 'class="width-15"'); ?>
					<span class="required-icon tooltip">Required</span>
				</li>
				
				<li>
					<label for="parent"><?php echo lang('galleries.parent_label'); ?></label>		
					<select name="parent" id="parent" size="1">
						<option value="NONE"><?php echo lang('galleries.none_label'); ?></option>
						<?php if ( !empty($galleries) ): foreach ( $galleries as $available_gallery ): ?>
						<option value="<?php echo $available_gallery->id; ?>"><?php echo $available_gallery->title; ?></option>
						<?php endforeach; endif; ?>
					</select>
				</li>
				
				<li class="even">
					<label for="description"><?php echo lang('galleries.description_label'); ?></label>
					<?php echo form_textarea(array('id'=>'description', 'name'=>'description', 'value' => $gallery->description, 'rows' => 10, 'class' => 'wysiwyg-simple')); ?>
				</li>
			</ol>
			
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		<?php echo form_close(); ?>
	</div>
</div>
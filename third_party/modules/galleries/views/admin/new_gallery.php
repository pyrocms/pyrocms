<div class="box" id="galleries_form_box">
	<h3>New Gallery</h3>
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
					<select name="parent" id="parent" size="1">
						<option value="NONE">-- NONE --</option>
						<?php if ( !empty($galleries) ): foreach ( $galleries as $available_gallery ): ?>
						<option value="<?php echo $available_gallery->id; ?>"><?php echo $available_gallery->title; ?></option>
						<?php endforeach; endif; ?>
					</select>
				</li>
				
				<li class="even">
					<label for="description">Description</label>
					<?php echo form_textarea(array('id'=>'description', 'name'=>'description', 'value' => $gallery->description, 'rows' => 10, 'class' => 'wysiwyg-simple')); ?>
				</li>
			</ol>
			
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		<?php echo form_close(); ?>
	</div>
</div>
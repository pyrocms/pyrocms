<div class="box">

	<?php if($method == 'create'): ?>
		<h3><?php echo lang('photo_albums.add_title');?></h3>
	<?php else: ?>
		<h3><?php echo sprintf(lang('photo_albums.edit_title'), $album->title);?></h3>
	<?php endif; ?>
	
	<div class="box-container">
		
		<?php echo form_open($this->uri->uri_string(), 'class="crud"'); ?>
			
			<ol>
				<li>
					<label for="title"><?php echo lang('photo_albums.title_label');?></label>
					<input type="text" id="title" name="title" maxlength="255" value="<?php echo $album->title; ?>" />
					<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
				</li>
				
				<li class="even">
					<label for="slug"><?php echo lang('photo_albums.slug_label');?></label>
					<?php echo form_input('slug', $album->slug, 'class="width-15"'); ?>
					<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
				</li>
				
				<li>
					<label for="parent"><?php echo lang('photo_albums.parent_album_label');?></label>		
					<select name="parent" size="1">
						<option value=""><?php echo lang('photo_albums.no_parent_select_label');?></option>
						<?php create_tree_select($albums, 0, 0, $album->parent, @$album->id); ?>
					</select>
				</li>
				
				<li class="even">
					<label for="description"><?php echo lang('photo_albums.desc_label');?></label>
					<?php echo form_textarea(array('id'=>'description', 'name'=>'description', 'value' => $album->description, 'rows' => 10, 'class' => 'wysiwyg-simple')); ?>
				</li>
			</ol>
			
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		<?php echo form_close(); ?>
	
	</div>
</div>
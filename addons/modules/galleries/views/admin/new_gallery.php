<h3><?php echo lang('galleries.new_gallery_label'); ?></h3>

<?php echo form_open(uri_string(), 'class="crud"'); ?>
	<ul>

		<li class="<?php echo alternator('', 'even'); ?>">
			<?php echo form_label(lang('galleries.folder_label'). ':', 'folder_id'); ?>
			<?php
			$folder_options = array(lang('select.pick'));
			foreach($file_folders as $row)
			{
				$indent = ($row['parent_id'] != 0) ? repeater('&nbsp;&raquo;&nbsp;', $row['depth']) : '';
				$folder_options[$row['id']] = $indent.$row['name'];
			}
			echo form_dropdown('folder_id', $folder_options, set_value('folder_id'), 'id="folder_id" class="required"');
			?>
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
	</ul>

	<div class="buttons float-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
	</div>

<?php echo form_close(); ?>

<script type="text/javascript">

jQuery(function($){
	$('select#folder_id').change(function(){
		$.get(BASE_URI + 'index.php/admin/galleries/ajax_select_folder/' + this.value.toString(), function(data) {

			if (data) {
				$('input[name=title]').val(data.name);
				$('input[name=slug]').val(data.slug);
			}
			else {
				$('input[name=title]').val('');
				$('input[name=slug]').val('');
			}

		}, 'json');
	});
});

</script>
<div id="galleries_upload_box">

	<h3><?php echo lang('gallery_images.upload_label'); ?></h3>

	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
		<ul>
			<li class="uploader_file_input">
				<label for="userfile"><?php echo lang('gallery_images.image_label'); ?></label>
				<input type="file" name="userfile" id="userfile" />
			</li>
			<li class="even">
				<label for="title"><?php echo lang('gallery_images.title_label'); ?></label>
				<input type="text" id="title" name="title" maxlength="255" value="<?php echo $gallery_image->title; ?>" />
			</li>
			<li>
				<label for="gallery_id"><?php echo lang('gallery_images.gallery_label'); ?></label>
				<select id="gallery_id" name="gallery_id">
					<?php
						foreach ( $galleries as $gallery )
						{
							$gid = !$this->session->flashdata('gallery_id') ? $this->input->post('gallery_id') : $this->session->flashdata('gallery_id');
							$selected = $gid == $gallery->id ? ' selected="selected"' : '';
							echo '<option value="' . $gallery->id . '"' . $selected . '>' . $gallery->title . '</option>';
						}
					?>
					
				</select>
			</li>
			<li class="even caption">
				<label for="description"><?php echo lang('gallery_images.description_label'); ?></label>
				<textarea id="description" name="description" rows="3" cols="20"><?php echo $gallery_image->description; ?></textarea>
			</li>
		</ul>

		<div class="buttons float-right padding-top">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		</div>

	<?php echo form_close(); ?>
</div>
<script type="text/javascript">
jQuery(function($) {
	$("a.button").click(function () {	
		parent.closeBox();
		return false;
	});	
});
</script>
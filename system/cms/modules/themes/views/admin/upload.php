<section class="title">
	<h4><?php echo lang('themes.upload_title');?></h4>
</section>

<section class="item">

<?php echo form_open_multipart('admin/themes/upload', array('class' => 'crud'));?>

	<ul>
		<li>
			<label for="userfile" style="float: none; display: inherit; width: auto; max-width: none; text-align: left; "><?php echo lang('themes.upload_desc'); ?></label><br/>
			<input type="file" name="userfile" class="input" />
		</li>
	</ul>
	
	<div><?php $this->load->view('admin/partials/buttons', array('buttons' => array('upload') )); ?></div>
	
<?php echo form_close(); ?>

</section>
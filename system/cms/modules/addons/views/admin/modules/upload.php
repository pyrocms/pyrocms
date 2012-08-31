<section class="title">
	<h4><?php echo lang('modules.upload_title');?></h4>
</section>

<section class="item">
<?php echo form_open_multipart('admin/modules/upload', array('class' => 'crud'));?>

	<ul>
		<li>
			<label for="userfile"><?php echo lang('modules.upload_desc');?></label><br/>
			<input type="file" name="userfile" class="input" />
		</li>
	</ul>
	
	<div class="buttons float-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('upload') )); ?>
	</div>
<?php echo form_close(); ?>
</section>

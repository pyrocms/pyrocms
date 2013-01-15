<section class="title">
	<h4><?php echo lang('addons:themes:upload_title');?></h4>
</section>

<section class="item">
	<div class="content">
	
		<?php echo form_open_multipart('admin/addons/themes/upload', array('class' => 'crud')) ?>
		
			<ul>
				<li>
					<h4><?php echo lang('addons:themes:upload_desc') ?></h4>
				</li>
				
				<li>
					<input type="file" name="userfile" class="input" />
				</li>
			</ul>
			
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('upload'))) ?>
			
		<?php echo form_close() ?>
	
	</div>
</section>
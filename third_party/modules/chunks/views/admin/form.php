<div class="box">
	
	<?php if($method == 'create_chunk'): ?>
		<h3><?php echo lang('chunks.add_chunk');?></h3>
	<?php else: ?>
		<h3><?php echo sprintf(lang('form.title.edit_form'), $chunk->name);?></h3>
	<?php endif; ?>

	<div class="box-container">	

	<?php echo form_open($this->uri->uri_string(), 'class="crud"'); ?>

	<div class="tabs">
	
		<ul class="tab-menu">
			<li><a href="#chunk-data-tab"><span>General Data</span></a></li>
			<li><a href="#chunk-content-tab"><span>Content</span></a></li>
		</ul>

		<div id="chunk-data-tab">
		
			<ol>
	
				<li>
					<label for="name"><?php echo lang('chunks.chunk_name');?></label>
					<?php echo form_input('name', htmlspecialchars_decode($chunk->name), 'maxlength="60"'); ?>
					<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
				</li>

				<li class="even">
					<label for="slug"><?php echo lang('chunks.chunk_slug');?></label>
					<?php echo form_input('slug', $chunk->slug, 'maxlength="60"'); ?>
					<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
				</li>

				<li>
					<label for="type"><?php echo lang('chunks.chunk_type');?></label>
					<?php echo form_dropdown('type', $chunk_types, $chunk->type); ?>
				</li>
			
			</ol>
			
		</div><!--chunk-data-tab-->

		<div id="chunk-content-tab">
		
			<ol>
	
				<li>
					<label for="name"><?php echo lang('chunks.chunk_content');?></label>
					<?php echo form_textarea('content', $chunk->content, 'width="400"'); ?>
					<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
				</li>
	
			</ol>
			
		</div><!--chunk-content-tab-->

	</div><!--tabs-->

	<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>

	<?php echo form_close(); ?>
	
	</div><!--box-container-->
	
</div><!--box-->
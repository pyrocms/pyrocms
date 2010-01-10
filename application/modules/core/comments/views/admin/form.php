<div class="box">

	<h3><?php echo lang('comments.edit_title');?></h3>
	
	<div class="box-container">
	
	    <?php echo form_open($this->uri->uri_string(), 'class="crud"'); ?>
	    	
	    	<?php echo form_hidden('user_id', $comment->user_id); ?>
			<?php echo form_hidden('active', $comment->is_active); ?>
	
			<fieldset id="fieldset1">
				
				<ol>
					<?php if(!$comment->user_id > 0): ?>
					<li>
						<label for="name"><?php echo lang('comments.name_label');?>:</label>
						<?php echo form_input('name', $comment->name, 'class="text" maxlength="100"'); ?>
					</li>
			
					<li class="even">
						<label for="email"><?php echo lang('comments.email_label');?>:</label>
						<?php echo form_input('email', $comment->email, 'class="text" maxlength="100"'); ?>
					</li>
					<?php else: ?>
					<li>
						<label><?php echo lang('comments.name_label');?>:</label>
						<?php echo $comment->name;?>
					</li>
					<li class="even">
						<label><?php echo lang('comments.email_label');?>:</label>
						<?php echo $comment->email;?>
					</li>
					<?php endif; ?>
				
					<li>
						<label for="body"><?php echo lang('comments.message_label');?>:</label>
						<?php echo form_textarea(array('id'=>'body', 'name'=>'body', 'value' => $comment->body, 'rows' => 5, 'class'=>'wysiwyg-simple')); ?>
					</li>
				</ol>
						
			</fieldset>
		
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		
		<?php echo form_close(); ?>

	</div>
</div>
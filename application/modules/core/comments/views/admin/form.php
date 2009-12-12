<?php echo form_open($this->uri->uri_string()); ?>

	<?php echo form_hidden('user_id', $comment->user_id); ?>
	<?php echo form_hidden('active', $comment->is_active); ?>
	<div class="fieldset fieldsetBlock active tabs">	
		
		<div class="header">
			<h3><?php echo lang('comment_edit_title');?></h3>
		</div>
    	
		<fieldset id="fieldset1">
			<legend><?php echo lang('comment_edit_label');?></legend>
			
			<?php if(!$comment->user_id > 0): ?>
				<div class="field">
					<label for="name"><?php echo lang('comment_name_label');?>:</label>
					<?php echo form_input('name', $comment->name, 'class="text" maxlength="100"'); ?>
					<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
				</div>
		
				<div class="field">
					<label for="email"><?php echo lang('comment_email_label');?>:</label>
					<?php echo form_input('email', $comment->email, 'class="text" maxlength="100"'); ?>
					<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
				</div>
			<?php else: ?>
				<div><?php echo $comment->name;?></div>
				<div><?php echo $comment->email;?></div>
			<?php endif; ?>
			
			<div class="field spacer-left">
				<label for="body"><?php echo lang('comment_message_label');?>:</label>
				<?php echo form_textarea(array('id'=>'body', 'name'=>'body', 'value' => $comment->body, 'rows' => 5, 'class'=>'wysiwyg-simple')); ?>
				<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
			</div>
					
		</fieldset>
				
	</div>
	
	<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
	
<?php echo form_close(); ?>
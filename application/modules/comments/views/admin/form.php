<?= form_open($this->uri->uri_string()); ?>
	<?=form_hidden('user_id', $comment->user_id); ?>
	<?=form_hidden('active', $comment->is_active); ?>
	<div class="fieldset fieldsetBlock active tabs">	
		
		<div class="header">
			<h3><?=lang('comment_edit_title');?></h3>
		</div>
    	
		<fieldset id="fieldset1">
			<legend><?=lang('comment_edit_label');?></legend>
			
			<? if(!$comment->user_id > 0): ?>
				<div class="field">
					<label for="name"><?=lang('comment_name_label');?>:</label>
					<?=form_input('name', $comment->name, 'class="text" maxlength="100"'); ?>
					<span class="required-icon tooltip"><?=lang('comment_required_label');?></span>
				</div>
		
				<div class="field">
					<label for="email"><?=lang('comment_email_label');?>:</label>
					<?=form_input('email', $comment->email, 'class="text" maxlength="100"'); ?>
					<span class="required-icon tooltip"><?=lang('comment_required_label');?></span>
				</div>
			<? else: ?>
				<div><?=$comment->name;?></div>
				<div><?=$comment->email;?></div>
			<? endif; ?>
			
			<div class="field spacer-left">
				<label for="body"><?=lang('comment_message_label');?>:</label>
				<?=form_textarea(array('id'=>'body', 'name'=>'body', 'value' => $comment->body, 'rows' => 5, 'class'=>'wysiwyg-simple')); ?>
				<span class="required-icon tooltip"><?=lang('comment_required_label');?></span>
			</div>
					
		</fieldset>
				
	</div>
	<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?= form_close(); ?>
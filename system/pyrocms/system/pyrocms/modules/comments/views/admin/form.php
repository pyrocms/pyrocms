<h3><?php echo lang('comments.edit_title');?></h3>

<?php echo form_open($this->uri->uri_string(), 'class="crud"'); ?>

	<?php echo form_hidden('user_id', $comment->user_id); ?>
	<?php echo form_hidden('active', $comment->is_active); ?>

		<ul class="fields">
			<?php if(!$comment->user_id > 0): ?>
			<li>
				<label for="name"><?php echo lang('comments.name_label');?>:</label>
				<?php echo form_input('name', $comment->name, 'maxlength="100"'); ?>
			</li>

			<li class="even">
				<label for="email"><?php echo lang('comments.email_label');?>:</label>
				<?php echo form_input('email', $comment->email, 'maxlength="100"'); ?>
			</li>
			<?php else: ?>
			<li>
				<label><?php echo lang('comments.name_label');?>:</label>
				<p><?php echo $comment->name;?></p>
			</li>
			<li class="even">
				<label><?php echo lang('comments.email_label');?>:</label>
				<p><?php echo $comment->email;?></p>
			</li>
			<?php endif; ?>

			<li>
				<label for="body"><?php echo lang('comments.message_label');?>:</label>
				<?php echo form_textarea(array('name'=>'comment', 'value' => $comment->comment, 'rows' => 5, 'class'=>'wysiwyg-simple')); ?>
			</li>

			<li class="even">
				<label for="website"><?php echo lang('comments.website_label');?>:</label>
				<?php echo form_input('website', $comment->website); ?>
			</li>
		</ul>

	<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>

<?php echo form_close(); ?>
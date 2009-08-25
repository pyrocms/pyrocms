<?php
	$this->lang->module_load('comments', 'comments');
	// Brings back unvalidated input
	$comment = $this->session->flashdata('comment');
?>

<?php echo form_open('comments/create/'.$module.'/'.$id); ?>
	<?php echo form_hidden('redirect_to', $this->uri->uri_string()); ?>
	
	<div id="commentform">
		<?php if(!$this->session->userdata('user_id')): ?>
		<p>
			<label for="name"><?php echo lang('comment_name_label');?>:</label><br />
			<input type="text" name="name" id="name" maxlength="40" value="<?php echo $comment['name'] ?>" />
		</p>
		
		<p>
			<label for="email"><?php echo lang('comment_email_label');?>:</label><br />
			<input type="text" name="email" id="email" maxlength="40" value="<?php echo $comment['email'] ?>" />
		</p>
		<?php endif; ?>
		
		<p>
			<label for="message"><?php echo lang('comment_message_label');?>:</label><br />
			<textarea name="body" id="body" rows="5" cols="30" class="width-full"><?php echo $comment['body'] ?></textarea>
		</p>
		
		<?php if($this->settings->item('captcha_enabled') and !$this->user_lib->logged_in()):?>
			<?
				// add captcha
				$this->load->plugin('captcha');
				$vals = array(
					'img_path'	 => APPPATH.$this->settings->item('captcha_folder'),
					'img_url'	 => base_url().APPPATH_URI.$this->settings->item('captcha_folder')
				);
		
				$cap = create_captcha($vals);
				$this->session->set_flashdata('captcha_'.$cap['time'], $cap['word']);	
			?>
			<p>
				<label for="message"><?php echo lang('comment_capcha_desc');?></label><br />
				<?php echo $cap['image'];?><br />
				<input type="text" name="captcha" id="captcha" maxlength="40" />
				<input type="hidden" name="captcha_id" id="captcha_id" value="<?php echo $cap['time'];?>" />
			</p>
		<?php endif; ?>
		<p><?php echo form_submit('btnSend', lang('comment_send_label'));?></p>
	</div>
<?php echo form_close(); ?>

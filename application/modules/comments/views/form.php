<?php
	$this->lang->module_load('comments', 'comments');
	// Brings back unvalidated input
	$comment = $this->session->flashdata('comment');
?>

<?=form_open('comments/create/'.$module.'/'.$id); ?>
	<?=form_hidden('redirect_to', $this->uri->uri_string()); ?>
	
	<div id="commentform">
		<? if(!$this->session->userdata('user_id')): ?>
		<p>
			<label for="name"><?=lang('comment_name_label');?>:</label><br />
			<input type="text" name="name" id="name" maxlength="40" value="<?=$comment['name'] ?>" />
		</p>
		
		<p>
			<label for="email"><?=lang('comment_email_label');?>:</label><br />
			<input type="text" name="email" id="email" maxlength="40" value="<?=$comment['email'] ?>" />
		</p>
		<? endif; ?>
		
		<p>
			<label for="message"><?=lang('comment_message_label');?>:</label><br />
			<textarea name="body" id="body" rows="5" cols="30" class="width-full"><?=$comment['body'] ?></textarea>
		</p>
		
		<? if($this->settings->item('captcha_enabled') and !$this->user_lib->logged_in()):?>
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
				<label for="message"><?=lang('comment_capcha_desc');?></label><br />
				<?=$cap['image'];?><br />
				<input type="text" name="captcha" id="captcha" maxlength="40" />
				<input type="hidden" name="captcha_id" id="captcha_id" value="<?=$cap['time'];?>" />
			</p>
		<? endif; ?>
		<p><?=form_submit('btnSend', lang('comment_send_label'));?></p>
	</div>
<?=form_close(); ?>

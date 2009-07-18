		<? if ($this->session->flashdata('error')): ?>
		<div class="message message-error">
			<h6><?= lang('general_error_label');?></h6>
			<p><?= $this->session->flashdata('error'); ?></p>
			<a class="close icon icon_close" title="<?= lang('close_message');?>" href="#"></a>
		</div>
    <? endif; ?>
    
    <? if (!empty($this->validation->error_string)): ?>
    	<div class="message message-error">
			<h6><?= lang('required_error_label');?></h6>
			<p><?= $this->validation->error_string; ?></p>
			<a class="close icon icon_close" title="<?= lang('close_message');?>" href="#"></a>
		</div>
    <? endif; ?>
    
    <? if ($this->session->flashdata('notice')): ?>
    	<div class="message message-notice">
			<h6><?= lang('note_label');?></h6>
			<p><?=$this->session->flashdata('notice');?></p>
			<a class="close icon icon_close" title="<?= lang('close_message');?>" href="#"></a>
		</div>
    <? endif; ?>
    
    <? if ($this->session->flashdata('success')): ?>
    	<div class="message message-success">
			<h6><?= lang('success_label');?></h6>
			<p><?= $this->session->flashdata('success'); ?></p>
			<a class="close icon icon_close" title="<?= lang('close_message');?>" href="#"></a>
		</div>
    <? endif; ?>
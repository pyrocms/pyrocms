<?php if ($this->session->flashdata('error')): ?>
<div class="message error">
	<h6><?php echo lang('general_error_label');?></h6>
	<p><?php echo $this->session->flashdata('error'); ?></p>
	<a class="close" title="<?php echo lang('close_message');?>" href="#"></a>
</div>
<?php endif; ?>

<?php if (!empty($this->validation->error_string)): ?>
<div class="message error">
	<h6><?php echo lang('required_error_label');?></h6>
	<p><?php echo $this->validation->error_string; ?></p>
	<a class="close" title="<?php echo lang('close_message');?>" href="#"></a>
</div>
<?php endif; ?>

<?php if (validation_errors()): ?>
<div class="message error">
	<h6><?php echo lang('required_error_label');?></h6>
	<p><?php echo validation_errors(); ?></p>
	<a class="close" title="<?php echo lang('close_message');?>" href="#"></a>
</div>
<?php endif; ?>

<?php if (!empty($messages['error'])): ?>
<div class="message error">
	<h6><?php echo lang('required_error_label');?></h6>
	<p><?php echo $messages['error']; ?></p>
	<a class="close" title="<?php echo lang('close_message');?>" href="#"></a>
</div>
<?php endif; ?>

<?php if ($this->session->flashdata('notice')): ?>
    <div class="message notice">
		<h6><?php echo lang('note_label');?></h6>
		<p><?php echo $this->session->flashdata('notice');?></p>
		<a class="close" title="<?php echo lang('close_message');?>" href="#"></a>
	</div>
<?php endif; ?>

<?php if (!empty($messages['notice'])): ?>
<div class="message notice">
	<h6><?php echo lang('note_label');?></h6>
	<p><?php echo $messages['notice']; ?></p>
	<a class="close" title="<?php echo lang('close_message');?>" href="#"></a>
</div>
<?php endif; ?>

<?php if ($this->session->flashdata('success')): ?>
    <div class="message success">
		<h6><?php echo lang('success_label');?></h6>
		<p><?php echo $this->session->flashdata('success'); ?></p>
		<a class="close" title="<?php echo lang('close_message');?>" href="#"></a>
	</div>
<?php endif; ?>
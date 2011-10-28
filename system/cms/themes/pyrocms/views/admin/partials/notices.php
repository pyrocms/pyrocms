<?php if ($this->session->flashdata('error')): ?>
<div class="alert error">
	<div class="message"><?php echo $this->session->flashdata('error'); ?></div>
</div>
<?php endif; ?>

<?php if (validation_errors()): ?>
<div class="alert error">
	<div class="message"><?php echo validation_errors(); ?></div>
</div>
<?php endif; ?>

<?php if ( ! empty($messages['error'])): ?>
<div class="alert error">
	<div class="message"><?php echo $messages['error']; ?></div>
</div>
<?php endif; ?>

<?php if ($this->session->flashdata('notice')): ?>
<div class="alert warning">
	<div class="message"><?php echo $this->session->flashdata('notice');?></div>
</div>
<?php endif; ?>

<?php if ( ! empty($messages['notice'])): ?>
<div class="alert warning">
	<div class="message"><?php echo $messages['notice']; ?></div>
</div>
<?php endif; ?>

<?php if ($this->session->flashdata('success')): ?>
<div class="alert success">
	<div class="message"><?php echo $this->session->flashdata('success'); ?></div>
</div>
<?php endif; ?>

<?php if ( ! empty($messages['success'])): ?>
<div class="alert success">
	<div class="message"><?php echo $messages['success']; ?></div>
</div>
<?php endif; ?>

<?php 

	/**
	 * Admin Notification Event
	 */
	Events::trigger('admin_notification');
	
?>
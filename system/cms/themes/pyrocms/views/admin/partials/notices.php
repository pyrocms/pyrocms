<?php if ($this->session->flashdata('error')): ?>
<div style="border-left:none;border-right:none;" class="block-message block-message-error alert">
	<?php echo $this->session->flashdata('error'); ?>
</div>
<?php endif; ?>

<?php if (validation_errors()): ?>
<div style="border-left:none;border-right:none;" class="block-message block-message-error alert">
	<?php echo validation_errors(); ?>
</div>
<?php endif; ?>

<?php if ( ! empty($messages['error'])): ?>
<div style="border-left:none;border-right:none;" class="block-message block-message-error alert">
	<?php echo $messages['error']; ?>
</div>
<?php endif; ?>

<?php if ($this->session->flashdata('notice')): ?>
<div style="border-left:none;border-right:none;" class="block-message block-message-warning alert">
	<?php echo $this->session->flashdata('notice');?>
</div>
<?php endif; ?>

<?php if ( ! empty($messages['notice'])): ?>
<div style="border-left:none;border-right:none;" class="block-message block-message-warning alert">
	<?php echo $messages['notice']; ?>
</div>
<?php endif; ?>

<?php if ($this->session->flashdata('success')): ?>
<div style="border-left:none;border-right:none;" class="block-message block-message-success alert">
	<?php echo $this->session->flashdata('success'); ?>
</div>
<?php endif; ?>

<?php if ( ! empty($messages['success'])): ?>
<div style="border-left:none;border-right:none;" class="block-message block-message-success alert">
	<?php echo $messages['success']; ?>
</div>
<?php endif; ?>

<?php 

	/**
	 * Admin Notification Event
	 */
	Events::trigger('admin_notification');
	
?>
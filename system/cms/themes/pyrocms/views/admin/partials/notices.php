<?php if ($this->session->flashdata('error')): ?>
<script type="text/javascript">
	Messenger().post({message: '<?php echo $this->session->flashdata('error'); ?>', type: 'error', showCloseButton: true});
</script>
<?php endif; ?>

<?php if (validation_errors()): ?>
<script type="text/javascript">
	<?php foreach (explode("\n", validation_errors()) as $message): ?>
	<?php if (empty($message)) continue; ?>
	Messenger().post({message: '<?php echo $message; ?>', type: 'error', showCloseButton: true});
	<?php endforeach; ?>
</script>
<?php endif; ?>

<?php if ( ! empty($messages['error'])): ?>
<script type="text/javascript">
	Messenger().post({message: '<?php echo $messages['error']; ?>', type: 'error', showCloseButton: true});
</script>
<?php endif; ?>

<?php if ($this->session->flashdata('notice')): ?>
<script type="text/javascript">
	Messenger().post({message: '<?php echo $this->session->flashdata('notice'); ?>', type: 'info', showCloseButton: true});
</script>
<?php endif; ?>

<?php if ( ! empty($messages['notice'])): ?>
<script type="text/javascript">
	Messenger().post({message: '<?php echo $messages['notice']; ?>', type: 'info', showCloseButton: true});
</script>
<?php endif; ?>

<?php if ($this->session->flashdata('success')): ?>
<script type="text/javascript">
	Messenger().post({message: '<?php echo $this->session->flashdata('success'); ?>', type: 'success', showCloseButton: true});
</script>
<?php endif; ?>

<?php if ( ! empty($messages['success'])): ?>
<script type="text/javascript">
	Messenger().post({message: '<?php echo $messages['success']; ?>', type: 'success', showCloseButton: true});
</script>
<?php endif; ?>

<?php 

	/**
	 * Admin Notification Event
	 */
	Events::trigger('admin_notification');
	
?>
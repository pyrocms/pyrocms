<?php if ($this->session->flashdata('error')): ?>
<div class="closable notification error">
	<?php echo $this->session->flashdata('error'); ?>
</div>
<?php endif; ?>

<?php if (!empty($this->validation->error_string)): ?>
<div class="closable notification error">
	<?php echo $this->validation->error_string; ?>
</div>
<?php endif; ?>

<?php if (validation_errors()): ?>
<div class="closable notification error">
	<p><?php echo validation_errors(); ?></p>
</div>
<?php endif; ?>

<?php if (!empty($messages['error'])): ?>
<div class="closable notification error">
	<?php echo $messages['error']; ?>
</div>
<?php endif; ?>

<?php if ($this->session->flashdata('notice')): ?>
<div class="closable notification attention">
	<?php echo $this->session->flashdata('notice');?>
</div>
<?php endif; ?>

<?php if (!empty($messages['notice'])): ?>
<div class="closable notification attention">
	<?php echo $messages['notice']; ?>
</div>
<?php endif; ?>

<?php if ($this->session->flashdata('success')): ?>
<div class="closable notification success">
	<?php echo $this->session->flashdata('success'); ?>
</div>
<?php endif; ?>
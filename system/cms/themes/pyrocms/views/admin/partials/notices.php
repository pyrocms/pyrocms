<?php
$messages = array_merge(array('error' => '', 'notice' => '', 'success' => ''), (!empty($messages) ) ? $messages : array());
$errors = array(
	'error' => array($messages['error'], $this->session->flashdata('error'), validation_errors()),
	'warning' => array($messages['notice'], $this->session->flashdata('notice')),
	'success' => array($messages['success'], $this->session->flashdata('success')),
);
?>

<?php foreach ($errors as $type => $msgs):?>
	<?php foreach ( $msgs as $msg):?>
		<?php if (!empty($msg)):?>
			<div class="alert <?php echo $type;?>"><?php echo $msg;?></div>
		<?php endif; ?>
	<?php endforeach ;?>
<?php endforeach;?>

<?php
/* Admin Notification Event */
Events::trigger('admin_notification');

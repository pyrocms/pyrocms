<table class="message_list" border="0" cellspacing="0">
	<thead>
		<tr>
			<th width="2%">
				<?php echo form_checkbox(array('name' => 'check_all_action','id' => 'check_all_action','value' => '0', 'checked' => FALSE)); ?>
			</th>
			<th width="15%">To</th>
			<th width="60%">Subject</th>
			<th width="23%">Sent</th>
		</tr>
	</thead>

	<tbody>

		<?php if(empty($messages)):?>
		<tr>
			<td colspan="4" align="center"><?php echo lang('messages_no_messages_title'); ?></td>
		</tr>

		<?php else: ?>

		  <?php foreach($messages as $msg): ?>
		  <tr>
			<td><?php echo form_checkbox(array('name' => 'action','value' => $msg->id, 'checked' => FALSE)); ?></td>
			<td valign="top">
				<?php echo $msg->to->first_name . ' ' . $msg->to->last_name; ?>
			</td>
			<td valign="top">
				<?php echo anchor('messages/sent/view/'.$msg->id, $msg->subject); ?>
			</td>
			<td valign="top">
				<?php echo  date('m.d.y g:i a', $msg->sent); ?>
			</td>
		  </tr>
		  <?php endforeach; ?>
  	</tbody>

  <?php endif;?>
</table>
<div class="message_links">
	<?php echo anchor('messages/reply/' . $message->id, lang('messages_reply_title')); ?> |
	<?php echo anchor('messages/delete/' . $message->id, lang('messages_trash_title')); ?>
</div>
<table class="message_table" border="0" cellspacing="0">
	<thead>
		<tr>
			<th colspan="2" class="header"><?php echo $message->subject; ?></th>
		</tr>
		<tr>
			<th>Sent:</th>
			<td><?php echo date("m.d.y \a\\t g.i a", $message->sent);?></td>
		</tr>
		<tr>
			<th>From:</th>
			<td><?php echo $from->first_name . ' ' . $from->last_name;?></td>
		</tr>

	<tbody>
		<tr>
			<th>Message:</th>
			<td><?php echo parse_bbcode($message->content); ?></td>
		</tr>
	</tbody>
</table>
<div class="message_links">
	<?php echo anchor('messages/' . $method . '/reply/' . $message->id, lang('messages_reply_title')); ?> |
	<?php echo anchor('messages/' . $method . '/delete/' . $message->id, lang('messages_trash_title')); ?>
</div>

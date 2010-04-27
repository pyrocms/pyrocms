<h2><?php echo lang('messages_title'); ?></h2>

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

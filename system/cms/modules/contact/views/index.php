<table class="table-list">
	<thead>
		<tr>
			<th><?php echo lang('contact_name_label');?></th>
			<th><?php echo lang('contact_subject_label');?></th>
			<th><?php echo lang('contact_message_label');?></th>
			<th>IP</th>
			<th><?php echo lang('contact_message_label');?></th>
		</tr>
	</thead>
	<tbody>
	<?php foreach ($contact_log as $log): ?>
		<tr>
			<td><?php echo mailto($log->email, $log->name) ?></td>
			<td><?php echo $log->subject ?></td>
			<td>
				<span class="short"><?php echo word_limiter($log->message, 20) ?></span>
				<span class="full" style="display:none"><?php echo $log->message ?></span>
			</td>
			<td><?php echo $log->sender_ip ?></td>
			<td><?php echo format_date($log->sent_at) ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
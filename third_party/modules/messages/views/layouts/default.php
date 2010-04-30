<div class="tabs">
	<ul>
		<li class="<?php echo ($method == 'inbox') ? 'selected-tab' : 'normal-tab'; ?>">
			<?php echo anchor('messages/inbox', '<span>' . lang('messages_inbox_title') . (($unread > 0) ? ' (' . $unread . ')' : '') . '</span>'); ?>
		</li>
		<li class="<?php echo ($method == 'sent') ? 'selected-tab' : 'normal-tab'; ?>">
			<?php echo anchor('messages/sent', '<span>' . lang('messages_sent_title') . '</span>'); ?>
		</li>
		<!--
		<li class="<?php echo ($method == 'trash') ? 'selected-tab' : 'normal-tab'; ?>">
			<?php echo anchor('messages/trash', '<span>' . lang('messages_trash_title') . '</span>'); ?>
		</li>
		-->
		<li class="<?php echo ($method == 'compose') ? 'right-tab selected-tab' : 'right-tab'; ?>">
			<?php echo anchor('messages/compose', '<span>' . lang('messages_compose_title') . '</span>'); ?>
		</li>
	</ul>
</div>
<div class="tab-container">
	<div class="tab-content">
		<?php echo $messages_body; ?>
	</div>
</div>
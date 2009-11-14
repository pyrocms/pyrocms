<?php echo form_open('admin/navigation/delete');?>
	<p class="float-right">[ <?=anchor('admin/navigation/groups/create', lang('nav_group_add_label')) ?> ]</p>
	<br class="clear-both" />
	<div class="message message-notice">
		<h6><?=lang('nav_note_label');?></h6>
		<p><?=lang('nav_group_note');?></p>
		<a class="close icon icon_close tooltip" href="#"></a>
	</div>
	<br class="clear-both" />
	
	<?php if (!empty($groups)): ?>
		<?php foreach ($groups as $group): ?>	
			<h3 class="float-left"><?=$group->title;?></h3>	
			<p class="float-right">[ <?php echo anchor('admin/navigation/groups/delete/'.$group->id, sprintf(lang('nav_group_delete_label'), $group->title), 'class="delete_group"') ?> ]</p>		
			<table border="0" class="listTable clear-both">		    
				<thead>
					<tr>
						<th class="first"><div></div></th>
						<th class="width-10"><a href="#"><?php echo lang('nav_title_label');?></a></th>
						<th class="width-5"><a href="#"><?php echo lang('nav_position_label');?></a></th>
						<th class="width-20"><a href="#"><?php echo lang('nav_url_label');?></a></th>
						<th class="last width-10"><span><?php echo lang('nav_actions_label');?></span></th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<td colspan="5">
							<div class="inner"></div>
						</td>
					</tr>
				</tfoot>
				<tbody>
				<?php if (!empty($navigation[$group->abbrev])): ?>
					<?php foreach ($navigation[$group->abbrev] as $navigation_link): ?>
					<tr>
						<td><input type="checkbox" name="delete[<?php echo $navigation_link->id;?>]" /></td>
						<td><?php echo $navigation_link->title;?></td>
						<td><?php echo $navigation_link->position; ?></td>
						<td><?php echo anchor($navigation_link->url, $navigation_link->url, 'target="_blank"');?></td>
						<td>
							<?php echo anchor('admin/navigation/edit/' . $navigation_link->id, lang('nav_edit_label'));?> | 
							<?php echo anchor('admin/navigation/delete/' . $navigation_link->id, lang('nav_delete_label'), array('class'=>'confirm'));?>
						</td>
					</tr>
					<?php endforeach; ?>		
				<?php else:?>
					<tr>
						<td colspan="5"><?php echo lang('nav_group_no_links');?></td>
					</tr>
				<?php endif; ?>		
			</tbody>
		</table>	
		<br/>	
		<? endforeach; ?>	
	<?php else: ?>
		<p><?php echo lang('nav_no_groups');?></p>
	<?php endif; ?>
	<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('delete') )); ?>

<?php echo form_close(); ?>

<script type="text/javascript">
(function($) {
	$(function() {
		
		$('a.delete_group').click(function(){
			return confirm('<?php echo lang('nav_group_delete_confirm');?>');
		});
		
	});
})(jQuery);
</script>
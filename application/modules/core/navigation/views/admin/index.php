<?php if (!empty($groups)): ?>
	<?php foreach ($groups as $group): ?>
	
		<div class="box">
			<h3><?php echo $group->title;?></h3>	
			
			<div class="box-container">
			
				<?php echo form_open('admin/navigation/delete');?>
				
					<div class="button small spacer-bottom float-right">
						<?php echo anchor('admin/navigation/groups/delete/'.$group->id, sprintf(lang('nav_group_delete_label'), $group->title), 'class="delete_group"') ?>
					</div>
			
					<?php if (!empty($navigation[$group->abbrev])): ?>
					
						<table border="0" class="table-list">		    
							<thead>
								<tr>
									<th class="width-5"><?php echo form_checkbox('action_to_all');?></th>
									<th class="width-30"><?php echo lang('nav_title_label');?></th>
									<th class="width-25"><?php echo lang('nav_url_label');?></th>
									<th class="width-10"><?php echo lang('nav_actions_label');?></th>
								</tr>
							</thead>
							<tbody>
								<?php foreach ($navigation[$group->abbrev] as $navigation_link): ?>
								<tr>
									<td><?php echo form_checkbox('action_to[]', $navigation_link->id); ?></td>
									<td><?php echo $navigation_link->title;?></td>
									<td><?php echo anchor($navigation_link->url, $navigation_link->url, 'target="_blank"');?></td>
									<td>
										<?php echo anchor('admin/navigation/edit/' . $navigation_link->id, lang('nav_edit_label'));?> | 
										<?php echo anchor('admin/navigation/delete/' . $navigation_link->id, lang('nav_delete_label'), array('class'=>'confirm'));?>
									</td>
								</tr>
								<?php endforeach; ?>	
							</tbody>
						</table>
											
						<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
											
					<?php else:?>
						<p><?php echo lang('nav_group_no_links');?></p>
					<?php endif; ?>	
		
				<?php echo form_close(); ?>
					
			</div>
		</div>
		
	<?php endforeach; ?>
		
<?php else: ?>
	<p><?php echo lang('nav_no_groups');?></p>
<?php endif; ?>

<script type="text/javascript">
(function($) {
	$(function() {
		
		$('a.delete_group').click(function(){
			return confirm('<?php echo lang('nav_group_delete_confirm');?>');
		});


		// Return a helper with preserved width of cells
		var fixHelper = function(e, ui) {
			ui.children().each(function() {
				$(this).width($(this).width());
			});
			return ui;
		};
		
		$('table tbody').sortable({
			handle: 'td',
			helper: fixHelper,
			update: function() {
				order = new Array();
				$('tr', this).each(function(){
					order.push( $(this).find('input[name="action_to[]"]').val() );
				});
				order = order.join(',');
				
				$.post(BASE_URI + 'admin/navigation/ajax_update_positions', { order: order });
			}
			
		}).disableSelection();
				
	});
})(jQuery);
</script>
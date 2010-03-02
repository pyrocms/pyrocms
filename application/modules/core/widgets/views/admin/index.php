<?php if (!empty($widget_areas)): ?>
	<?php foreach ($widget_areas as $group): ?>
	
		<div class="box">
			<h3><?php echo $group->title;?></h3>	
			
			<div class="box-container widget-area">
			
					
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


		$('table tbody').sortable({
			handle: 'td',
			update: function() {
				order = new Array();
				$('tr', this).each(function(){
					order.push( $(this).find('input[name="action_to[]"]').val() );
				});
				order = order.join(',');
				
				$.post(BASE_URI + 'widgets/ajax/update_positions', { order: order });
			}
			
		}).disableSelection();
				
	});
})(jQuery);
</script>
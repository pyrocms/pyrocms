<?php if ( ! empty($groups)): ?>
	<?php foreach ($groups as $group): ?>
	
		<section rel="<?php echo $group->id; ?>" class="group-<?php echo $group->id; ?> box">
			<section class="title">
				<ul>
					<li>
						<h4 class="tooltip" title="<?php echo lang('nav_abbrev_label').': '.$group->abbrev; ?>"><?php echo $group->title;?></h4>
						<?php echo anchor('admin/navigation/create/'.$group->id, lang('nav_link_create_title'), 'rel="'.$group->id.'" class="add ajax button"') ?>
					</li>
					
					<li>
						<h4 class="form-title group-title-<?php echo $group->id; ?>"></h4>
						<?php echo anchor('admin/navigation/groups/delete/'.$group->id, lang('global:delete'), array('class' => "confirm button",  'title' => lang('nav_group_delete_confirm'))) ?>
					</li>
				</ul>
			
			</section>
			
			<?php if ( ! empty($navigation[$group->id])): ?>
				
				<section class="item collapsed">
					
					<div style="background:#eeeeee;padding:15px 15px 0 0;" id="link-list">
						<ul class="sortable">
							<?php echo tree_builder($navigation[$group->id], '<li id="link_{{ id }}"><div><a href="#" rel="'.$group->id.'" alt="{{ id }}">{{ title }}</a></div>{{ children }}</li>'); ?>
						</ul>
					</div>
					
					<div id="link-details" class="group-<?php echo $group->id; ?>">
						
						<p>
							<?php echo lang('navs.tree_explanation'); ?>
						</p>
						
					</div>
						
				</section>
										
				<?php else:?>

				<section class="item collapsed">
					
					<div style="background:#eeeeee;padding:15px 15px 0 0;" id="link-list" class="empty">
						<ul class="sortable">
					
							<p><?php echo lang('nav_group_no_links');?></p>
					
						</ul>
					</div>
					
					<div id="link-details" class="group-<?php echo $group->id; ?>">
						
						<p>
							<?php echo lang('navs.tree_explanation'); ?>
						</p>
						
					</div>

				</section>
				<?php endif; ?>	
					
		</section>
		
	<?php endforeach; ?>
		
<?php else: ?>
	<div class="blank-slate">
		<p><?php echo lang('nav_no_groups');?></p>
	</div>
<?php endif; ?>
<?php if ( ! empty($groups)): ?>
	<?php foreach ($groups as $group): ?>
	
		<section rel="<?php echo $group->id; ?>" class="group-<?php echo $group->id; ?> box">
			<section class="title">
				<ul>
					<li>
						<h4><?php echo $group->title;?></h4>
						<?php echo anchor('admin/navigation/create/'.$group->id, lang('nav_link_create_title'), 'rel="'.$group->id.'" class="add ajax button"') ?>
					</li>
					
					<li>
						<h4 class="form-title group-title-<?php echo $group->id; ?>"></h4>
						<?php echo anchor('admin/navigation/groups/delete/'.$group->id, lang('global:delete'), array('class' => "confirm button",  'title' => lang('nav_group_delete_confirm'))) ?>
					</li>
				</ul>
			
			</section>
			
			<?php if ( ! empty($navigation[$group->id])): ?>
				
				<section class="item">
					
					<div id="link-list">
						<ol class="sortable">
					
							<?php foreach($navigation[$group->id] as $link): ?>
						
									<li id="link_<?php echo $link['id']; ?>">
										<div>
											<a href="#" rel="<?php echo $group->id; ?>" alt="<?php echo $link['id']; ?>"><?php echo $link['title']; ?></a>
										</div>

								<?php if ($link['children']): ?>
										<ol>
											<?php $controller->tree_builder($link, $group->id); ?>
										</ol>
									</li>
								<?php else: ?>
									</li>
								<?php endif; ?>
									
							<?php endforeach; ?>
					
						</ol>
					</div>
					
					<div id="link-details" class="group-<?php echo $group->id; ?>">
						
						<p>
							<?php echo lang('navs.tree_explanation'); ?>
						</p>
						
					</div>
						
				</section>
										
				<?php else:?>

				<section class="item collapsed">
					
					<div id="link-list" class="empty">
						<ol class="sortable">
					
							<p><?php echo lang('nav_group_no_links');?></p>
					
						</ol>
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
		<h2><?php echo lang('nav_no_groups');?></h2>
	</div>
<?php endif; ?>
<?php if ( ! empty($groups)): ?>
	<?php foreach ($groups as $group): ?>
	
		<section class="box">
			<header>
				<div class="float-right" style="margin-top: 6px;">
					<?php echo anchor('admin/navigation/groups/delete/'.$group->id, lang('nav_group_delete_label'), array('class' => "confirm minibutton",  'title' => lang('nav_group_delete_confirm'))) ?>
				</div>
			
				<h3><?php echo $group->title;?></h3>
			</header>
			
			<?php echo form_open('admin/navigation/delete');?>
		
				<?php if ( ! empty($navigation[$group->abbrev])): ?>
				
					<table border="0" class="table-list">		    
						<thead>
							<tr>
								<th style="width: 3em"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
								<th style="width: 20%"><?php echo lang('nav_title_label');?></th>
								<th style="width: 30%"><?php echo lang('nav_url_label');?></th>
								<th style="width: 15%"><?php echo lang('nav_target_label');?></th>
								<th style="width: 15%"><?php echo lang('nav_class_label');?></th>
								<th style="width: 5em">&nbsp;</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($navigation[$group->abbrev] as $navigation_link): ?>
							<tr class="hover-toggle">
								<td><?php echo form_checkbox('action_to[]', $navigation_link->id); ?></td>
								<td><?php echo $navigation_link->title;?></td>
								<td><?php echo anchor($navigation_link->url, $navigation_link->url, 'target="_blank"');?></td>
								<td><?php echo $navigation_link->target;?></td>
								<td><?php echo $navigation_link->class;?></td>
								<td width="180" align="right">
                                	<span class="toggle-item">
									<?php echo anchor('admin/navigation/edit/' . $navigation_link->id, lang('nav_edit_label'), array('class'=>'minibutton'));?>  
									<?php echo anchor('admin/navigation/delete/' . $navigation_link->id, lang('nav_delete_label'), array('class'=>'confirm minibutton'));?>
                                    </span>
								</td>
							</tr>
							<?php endforeach; ?>	
						</tbody>
					</table>
					
					<footer>	
						<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
					</footer>
										
				<?php else:?>
					<p><?php echo lang('nav_group_no_links');?></p>
				<?php endif; ?>	
	
			<?php echo form_close(); ?>
					
		</section>
		
	<?php endforeach; ?>
		
<?php else: ?>
	<div class="blank-slate">
		<h2><?php echo lang('nav_no_groups');?></h2>
	</div>
<?php endif; ?>
<div class="box">
	<h3><?php echo lang('themes.list_label');?></h3>
	
	<div class="box-container">
	
		<?php echo form_open('admin/themes/delete');?>
	
			<table border="0" class="table-list">
			  <thead>
				<tr>
					<th><?php echo form_checkbox('action_to_all');?></th>
					<th><?php echo lang('themes.theme_label');?></th>
					<th class="width-quater"><span><?php echo lang('themes.actions_label');?></span></th>
				</tr>
			  </thead>
			  <tfoot>
			  	<tr>
			  		<td colspan="3">
			  			<div class="inner"></div>
			  		</td>
			  	</tr>
			  </tfoot>  
				<tbody>	
				<?php if (!empty($themes)): ?>
					<?php foreach ($themes as $theme): ?>
					<tr>
						<td align="center"><?php echo form_checkbox('action_to[]', $theme['id']); ?></td>
						<td>
							<h4 class="header">
								<?php if (!empty($theme['website'])): ?>
									<?php echo anchor($theme['website'], $theme['name'], array('target'=>'_blank')); ?>
								<?php else: ?>
									<?php echo $theme['name']; ?>
								<?php endif; ?>
								 by 
								<?php if ($theme['author_website']): ?>
									<?php echo anchor($theme['author_website'], $theme['author'], array('target'=>'_blank')); ?>
								<?php else: ?>
									<?php echo $theme['author']; ?>
								<?php endif; ?>
								| version <?php echo $theme['version']; ?>
							</h4>
							
							<div class="screenshot float-left spacer-right">
							  	<img src="<?php $screenshot = $theme['path'] . '/screenshot.png'; if(file_exists($screenshot)){ echo APPPATH_URI . 'themes/' . $theme['id'] . '/screenshot.png'; } else { echo base_url() . 'application/modules/themes/views/screenshot.png'; } ?>" alt="<?php echo $theme['name'] ?>" width="180" height="140" />
						  	</div>
							 
							<p><?php echo $theme['description']; ?></p>
						</td>
						<td>
							<?php if($this->settings->item('default_theme') != $theme['id']): ?>
								<?php echo anchor('admin/themes/set_default/' . $theme['id'], lang('themes.make_default'), array('class' => 'ajax')).' | '; ?>
								<?php echo anchor('admin/themes/delete/' . $theme['id'], lang('themes.delete'), array('class'=>'confirm')); ?>
							<?php else: ?>
								<em><?php echo lang('themes.default_theme_label');?></em>
							<?php endif; ?>
						</td>
					</tr>
					<?php endforeach; ?>
				<?php else: ?>
					<tr><td colspan="3"><?php echo lang('themes.no_themes_installed');?></td></tr>
				<?php endif; ?>
				</tbody>
			</table>
			
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
		
		<?php echo form_close(); ?>
		
	</div>
</div>
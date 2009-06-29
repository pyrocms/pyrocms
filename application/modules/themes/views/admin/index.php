<?php echo form_open('admin/themes/delete');?>
<table border="0" class="listTable">
  <thead>
	<tr>
		<th class="first"><div></div></th>
		<th><a href="#"><?php echo lang('theme_theme_label');?></a></th>
		<th class="last width-quater"><span><?php echo lang('theme_actions_label');?></span></th>
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
			<td align="center"><input type="checkbox" name="action_to[]" value="<?php echo $theme['name']; ?>" /></td>
			<td>
				<h4 class="header">
					<?php if ($theme['website']): ?>
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
			<td>
				<?php if($this->settings->item('default_theme') != $theme['id']): ?>
					<?php echo anchor('admin/themes/set_default/' . $theme['id'], lang('theme_make_default'), array('class' => 'ajax')).' | '; ?>
					<?php echo anchor('admin/themes/delete/' . $theme['id'], lang('theme_delete'), array('class'=>'confirm')); ?>
				<?php else: ?>
					<i><?php echo lang('theme_default_theme_label');?></i>
				<?php endif; ?>
			</td>
		</tr>
		<?php endforeach; ?>
	<?php else: ?>
		<tr><td colspan="3"><?php echo lang('theme_no_themes_installed');?></td></tr>
	<?php endif; ?>
	</tbody>
</table>
<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('delete') )); ?>
<?php echo form_close(); ?>
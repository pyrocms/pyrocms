<?= form_open('admin/themes/delete');?>
<table border="0" class="listTable">
  <thead>
	<tr>
		<th class="first"><div></div></th>
		<th><a href="#"><?= lang('theme_theme_label');?></a></th>
		<th class="last width-quater"><span><?= lang('theme_actions_label');?></span></th>
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
	<? if (!empty($themes)): ?>
		<? foreach ($themes as $theme): ?>
		<tr>
			<td align="center"><input type="checkbox" name="action_to[]" value="<?=$theme->name?>" /></td>
			<td><?=$theme->name?></td>
			<td>
				<? if($this->settings->item('default_theme') != $theme->name): ?>
					<? echo anchor('admin/themes/set_default/' . $theme->slug, lang('theme_make_default'), array('class' => 'ajax')).' | '; ?>
					<? echo anchor('admin/themes/delete/' . $theme->slug, lang('theme_delete'), array('class'=>'confirm')); ?>
				<? else: ?>
					<i><?= lang('theme_default_theme_label');?></i>
				<? endif; ?>
			</td>
		</tr>
		<? endforeach; ?>
	<? else: ?>
		<tr><td colspan="3"><?= lang('theme_no_themes_installed');?></td></tr>
	<? endif; ?>
	</tbody>
</table>
<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('delete') )); ?>
<?=form_close(); ?>
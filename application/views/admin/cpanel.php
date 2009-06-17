<?
/*foreach($this->modules_m->getModules(array('is_backend'=>true, 'type'=>'admin')) as $module): ?>
	<div class="width-quater float-left align-center" style="height:8em">
		<?= anchor('admin/'.$module['slug'], $module['name']); ?>
	</div>
<? endforeach;*/
?>
<p class="align-center">
	<strong><?= sprintf(lang('cp_welcome'), $this->settings->item('site_name'));?></strong>
</p>
<h3 class="spacer-top"><a name="modules"><?= lang('mod_title');?></a></h3>
<table class="listTable">
	<thead>
		<tr>
			<th class="first"><div></div></th>
			<th><a href="#"><?= lang('name_label');?></a></th>
			<th><?= lang('desc_label');?></th>
			<th class="last"><a href="#"><?= lang('version_label');?></a></th>
		</tr>
	</thead>	
	<tbody>
	<? foreach($modules as $module): ?>
		<tr>
			<td></td>
			<td><?=$module['name'] ?></td>
			<td><?=$module['description'] ?></td>
			<td class="align-center"><?=$module['version'] ?></td>
		</tr>
	<? endforeach; ?>
	</tbody>	
</table>
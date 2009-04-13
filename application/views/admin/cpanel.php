<p class="align-center">
	<strong>Welcome to the <?=$this->settings->item('site_name'); ?> Control Panel. Using the links above and to the left you can 
	control almost every aspect of your website. For a full list of modules, please <a href="#modules">see below</a>.</strong>
</p>

<? /*foreach($this->modules_m->getModules(array('is_backend'=>true, 'type'=>'admin')) as $module): ?>
	<div class="width-quater float-left align-center" style="height:8em">
		<?= anchor('admin/'.$module['slug'], $module['name']); ?>
	</div>
<? endforeach;*/ ?>

<h3 class="spacer-top"><a name="modules">Modules</a></h3>

<table class="listTable">
	<thead>
		<tr>
			<th class="first"><div></div></th>
			<th><a href="#">Name</a></th>
			<th>Description</th>
			<th class="last"><a href="#">Version</a></th>
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

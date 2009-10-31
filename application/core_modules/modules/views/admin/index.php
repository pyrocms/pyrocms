<p class="align-center">
	<strong>Below is a list of installed modules and their information, such as the description or version.</strong>
</p>
<h3 class="spacer-top"><a name="modules"><?php echo lang('mod_title');?></a></h3>
<table class="listTable">
	<thead>
		<tr>
			<th class="first"><div></div></th>
			<th><a href="#"><?php echo lang('name_label');?></a></th>
			<th><span><?php echo lang('desc_label');?></span></th>
			<th class="last"><a href="#"><?php echo lang('version_label');?></a></th>
		</tr>
	</thead>	
	<tbody>
	<?php foreach($modules as $module): ?>
		<tr>
			<td></td>
			<td><?php echo $module['name']; ?></td>
			<td><?php echo $module['description']; ?></td>
			<td class="align-center"><?php echo $module['version']; ?></td>
		</tr>
	<?php endforeach; ?>
	</tbody>	
</table>
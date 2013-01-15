<div id="details-container">
	<h4><?php echo $link->title ?></h4>
	
	<input id="link-id" type="hidden" value="<?php echo $link->id ?>" />
	<input id="link-uri" type="hidden" value="<?php echo ! empty($link->uri) ? $link->uri : '' ?>" />

	<fieldset>
		<legend><?php echo lang('nav:details_label') ?></legend>
		<p>
			<strong>ID:</strong> #<?php echo $link->id ?>
		</p>

		<p>
			<strong><?php echo lang('global:title');?>:</strong> <?php echo $link->title ?>
		</p>
		
		<p>
			<strong><?php echo lang('nav:target_label');?>:</strong> <?php echo (!empty($link->target)) ? lang('nav:link_target_blank') : lang('nav:link_target_self') ?>
		</p>
		
		<p>
			<strong><?php echo lang('nav:class_label');?>:</strong> <?php echo $link->class ?>
		</p>
		
		<p>
			<strong><?php echo lang('nav:type_label');?>:</strong> <?php echo $link->link_type ?>
		</p>
		
		<p>
			<strong><?php echo lang('nav:location_label');?>:</strong>
			<a target="_blank" href="<?php echo $link->url ?>"><?php echo $link->url ?></a>
		</p>
		
		<p>
			<strong><?php echo lang('nav:restricted_to');?>:</strong> <?php echo $link->restricted_to ?>
		</p>
	</fieldset>	
	
	<div class="buttons">
		<?php echo anchor('admin/navigation/edit/' . $link->id, lang('global:edit'), 'rel="'.$link->navigation_group_id.'" class="button ajax"') ?>
		<?php echo anchor('admin/navigation/delete/' . $link->id, lang('global:delete'), 'class="confirm button"') ?>
	</div>
</div>
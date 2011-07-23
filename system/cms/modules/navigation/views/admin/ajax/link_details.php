<div id="details-container">
	<h4><?php echo $link->title; ?></h4>
	
	<input id="link-id" type="hidden" value="<?php echo $link->id; ?>" />
	<input id="link-uri" type="hidden" value="<?php echo ! empty($link->uri) ? $link->uri : ''; ?>" />

	<fieldset>
		<legend><?php echo lang('nav_details_label'); ?></legend>
		<p>
			<strong>ID:</strong> #<?php echo $link->id; ?>
		</p>

		<p>
			<strong><?php echo lang('nav_title_label');?>:</strong> <?php echo $link->title; ?>
		</p>
		
		<p>
			<strong><?php echo lang('nav_target_label');?>:</strong> <?php echo (!empty($link->target)) ? lang('nav_link_target_blank') : lang('nav_link_target_self'); ?>
		</p>
		
		<p>
			<strong><?php echo lang('nav_class_label');?>:</strong> <?php echo $link->class; ?>
		</p>
		
		<p>
			<strong><?php echo lang('nav_type_label');?>:</strong> <?php echo $link->link_type; ?>
		</p>
		
		<p>
			<strong><?php echo lang('nav_location_label');?>:</strong>
			<a target="_blank" href="<?php echo $link->url; ?>"><?php echo $link->url; ?></a>
		</p>
	</fieldset>	
	
	<div class="buttons">
		<?php echo anchor('admin/navigation/edit/' . $link->id, lang('nav_edit_label'), 'rel="'.$link->navigation_group_id.'" class="button ajax"'); ?>
		<?php echo anchor('admin/navigation/delete/' . $link->id, lang('nav_delete_label'), 'class="confirm button"'); ?>
	</div>
</div>
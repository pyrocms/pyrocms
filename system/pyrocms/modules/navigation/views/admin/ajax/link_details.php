<div id="details-container">
	<h4><?php echo $link->title; ?></h4>
	
	<input id="link-id" type="hidden" value="<?php echo $link->id; ?>" />
	<input id="link-uri" type="hidden" value="<?php echo !empty($link->uri) ? $link->uri : $link->slug; ?>" />
	
	<fieldset>
		<legend><?php echo lang('links.detail_label'); ?></legend>
		<p>
			<strong>ID:</strong> #<?php echo $link->id; ?>
		</p>
		<p>
			<strong><?php echo lang('links.status_label'); ?>:</strong> <?php echo lang('links.' . $link->status . '_label'); ?>
		</p>
		<p>
			<strong><?php echo lang('links.slug_label');?>:</strong> 
			<a href="<?php echo site_url('admin/links/preview/'.$link->id);?>?iframe" rel="modal-large" target="_blank">
				<?php echo site_url(!empty($link->uri) ? $link->uri : $link->slug); ?>
			</a>
		</p>
	</fieldset>
	
	<!-- Meta data tab -->
	<fieldset>
		<legend><?php echo lang('links.meta_label');?></legend>
		<p>
			<strong><?php echo lang('links.meta_title_label');?>:</strong> <?php echo !empty($link->meta_title) ? $link->meta_title : '&mdash;'; ?>
		</p>
		<p>
			<strong><?php echo lang('links.meta_keywords_label');?>:</strong> <?php echo !empty($link->meta_keywords) ? $link->meta_keywords : '&mdash;'; ?>
		</p>
		<p>
			<strong><?php echo lang('links.meta_desc_label');?>:</strong> <?php echo !empty($link->meta_description) ? $link->meta_description : '&mdash;'; ?>
		</p>
	</fieldset>	
	
	<div class="buttons">
		<?php echo anchor('admin/navigation/create/' . $link->id, lang('links.create_label'), 'class="button ajax"'); ?>
		<?php echo anchor('admin/navigation/edit/' . $link->id, lang('links.edit_label'), 'class="button ajax"'); ?>
		<?php echo anchor('admin/navigation/delete/' . $link->id, lang('links.delete_label'), 'class="confirm button"'); ?>
	</div>
</div>
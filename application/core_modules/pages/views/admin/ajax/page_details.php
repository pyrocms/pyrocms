<h3><?php echo $page->title; ?></h3>

<input id="page-id" type="hidden" value="<?php echo $page->id; ?>" />
<input id="page-path" type="hidden" value="<?php echo !empty($page->path) ? $page->path : $page->slug; ?>" />

<fieldset>
	<legend>Details</legend>
	<p>
		ID: #<?php echo $page->id; ?>
	</p>
	<p>
		<?php echo lang('page_url_label');?>: <?php echo anchor(!empty($page->path) ? $page->path : $page->slug); ?>
	</p>
</fieldset>

<!-- Meta data tab -->
<fieldset>
	<legend><?php echo lang('page_meta_label');?></legend>
	<p>
		<?php echo lang('page_meta_title_label');?>: <?php echo $page->meta_title; ?>
	</p>
	<p>
		<?php echo lang('page_meta_keywords_label');?>: <?php echo $page->meta_keywords; ?>
	</p>
	<p>
		<?php echo lang('page_meta_desc_label');?>: <?php echo $page->meta_description; ?>
	</p>
</fieldset>	

<div id="page-buttons">
	<div class="float-left">
		<a href="<?php echo site_url('admin/pages/create/' . $page->id); ?>">
			<button class="button">
				<strong>
					<?php echo lang('page_create_label');?>
					<img class="icon" alt="<?php echo lang('page_create_label'); ?>" src="<?=image_url('admin/icons/add_48.png');?>" />
				</strong>
			</button>
		</a>
	</div>
	
	<div class="float-left">
		<a href="<?php echo site_url('admin/pages/edit/' . $page->id); ?>">
			<button class="button">
				<strong>
					<?php echo lang('page_edit_label');?>
					<img class="icon" alt="<?php echo lang('page_edit_label'); ?>" src="<?=image_url('admin/icons/paper_content_pencil_48.png');?>" />
				</strong>
			</button>
		</a>
	</div>
	
	<div class="float-left">
		<a href="<?php echo site_url('admin/pages/delete/' . $page->id); ?>">
			<button class="button confirm">
				<strong>
					<?php echo lang('page_delete_label');?>
					<img class="icon" alt="<?php echo lang('page_delete_label'); ?>" src="<?php echo image_url('admin/icons/cross_48.png');?>" />
				</strong>
			</button>
		</a>
	</div>
</div>
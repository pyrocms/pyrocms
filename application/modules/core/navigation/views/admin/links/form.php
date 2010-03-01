<div class="box">
	
	<?php if($method == 'create'): ?>
		<h3><?php echo lang('nav_link_create_title');?></h3>
			
	<?php else: ?>
		<h3><?php echo sprintf(lang('nav_link_edit_title'), $this->data->navigation_link->title);?></h3>
		
	<?php endif; ?>
	
	<div class="box-container">

		<?php echo form_open($this->uri->uri_string(), 'class="crud"'); ?>
	
			<ol>
				<li class="even">
					<label for="title"><?php echo lang('nav_text_label');?></label>
					<?php echo form_input('title', $navigation_link->title, 'maxlength="50"'); ?>
				</li>
					
				<li>
					<label for="navigation_group_id"><?php echo lang('nav_group_label');?></label>
					<?php echo form_dropdown('navigation_group_id', $groups_select, $navigation_link->navigation_group_id, 'size="'.count($groups_select).'"') ?>
				</li>
				
				<li class="even">
					<label for="target"><?php echo lang('nav_target_label'); ?></label>
					<?php echo form_dropdown('target', array(''=> lang('nav_link_target_self'), '_blank' => lang('nav_link_target_blank')), $navigation_link->target); ?>
				</li>
				
				<li>
					<label for="link_type"><?php echo lang('nav_type_label');?></label>
					<span class="spacer-right">
						<?php echo form_radio('link_type', 'url', $navigation_link->link_type == 'url') ?> <?php echo lang('nav_url_label');?>
						<?php echo form_radio('link_type', 'uri', $navigation_link->link_type == 'uri') ?> <?php echo lang('nav_uri_label');?>
						<?php echo form_radio('link_type', 'module', $navigation_link->link_type == 'module') ?> <?php echo lang('nav_module_label');?>
						<?php echo form_radio('link_type', 'page', $navigation_link->link_type == 'page') ?> <?php echo lang('nav_page_label');?>
					</span>
				</li>
				
				<li class="even">
								
					<p class="<?php echo !empty($navigation_link->link_type) ? 'hidden' : ''; ?>">
						<?php echo lang('nav_link_type_desc');?>
					</p>
					
					<div id="navigation-url" class="<?php echo @$navigation_link->link_type == 'url' ? '' : 'hidden'; ?>">
						<label for="url"><?php echo lang('nav_url_label');?></label>
						<input type="text" id="url" name="url" value="<?php echo empty($navigation_link->url) ? 'http://' : $navigation_link->url; ?>" />
					</div>
						
					<div id="navigation-module" class="<?php echo @$navigation_link->link_type == 'module' ? '' : 'hidden'; ?>">
						<label for="module_name"><?php echo lang('nav_module_label');?></label>
						<?php echo form_dropdown('module_name', array(lang('nav_link_module_select_default'))+$modules_select, $navigation_link->module_name) ?>
					</div>
					
					<div id="navigation-uri" class="<?php echo @$navigation_link->link_type == 'uri' ? '' : 'hidden'; ?>">
						<label for="uri"><?php echo lang('nav_uri_label');?></label>
						<input type="text" id="uri" name="uri" value="<?php echo $navigation_link->uri; ?>" />
					</div>
					
					<div id="navigation-page" class="<?php echo @$navigation_link->link_type == 'page' ? '' : 'hidden'; ?>">
						<label for="page_id"><?php echo lang('nav_page_label');?></label>
						<select name="page_id">
							<option value=""><?php echo lang('nav_link_page_select_default');?></option>
							<?php create_tree_select($pages_select, 0, 0, $navigation_link->page_id); ?>
						</select>
					</div>
				</li>
			</ol>
	
			<br class="clear-both" />
					
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>

		<?php echo form_close(); ?>
		
	</div>
</div>
<?php if ($this->method == 'create'): ?>
	<h3><?php echo lang('nav_link_create_title');?></h3>
		
<?php else: ?>
	<h3><?php echo sprintf(lang('nav_link_edit_title'), $navigation_link->title);?></h3>
	
<?php endif; ?>

<?php echo form_open(uri_string(), 'class="crud"'); ?>

	<ul>
		<li class="even">
			<label for="title"><?php echo lang('nav_title_label');?></label>
			<?php echo form_input('title', $navigation_link->title, 'maxlength="50" class="text"'); ?>
			<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
		</li>

		<li>
			<label for="navigation_group_id"><?php echo lang('nav_group_label');?></label>
			<?php echo form_dropdown('navigation_group_id', $groups_select, $navigation_link->navigation_group_id) ?>
		</li>

		<li class="even">
			<label for="link_type"><?php echo lang('nav_type_label');?></label>
			<span class="spacer-right">
				<?php echo form_radio('link_type', 'url', $navigation_link->link_type == 'url') ?> <?php echo lang('nav_url_label');?>
				<?php echo form_radio('link_type', 'uri', $navigation_link->link_type == 'uri') ?> <?php echo lang('nav_uri_label');?>
				<?php echo form_radio('link_type', 'module', $navigation_link->link_type == 'module') ?> <?php echo lang('nav_module_label');?>
				<?php echo form_radio('link_type', 'page', $navigation_link->link_type == 'page') ?> <?php echo lang('nav_page_label');?>
			</span>
		</li>

		<li>

			<p style="<?php echo ! empty($navigation_link->link_type) ? 'display:none' : ''; ?>">
				<?php echo lang('nav_link_type_desc');?>
			</p>

			<div id="navigation-url" style="<?php echo @$navigation_link->link_type == 'url' ? '' : 'display:none'; ?>">
				<label for="url"><?php echo lang('nav_url_label');?></label>
				<input type="text" id="url" name="url" value="<?php echo empty($navigation_link->url) ? 'http://' : $navigation_link->url; ?>" />
			</div>

			<div id="navigation-module" style="<?php echo @$navigation_link->link_type == 'module' ? '' : 'display:none'; ?>">
				<label for="module_name"><?php echo lang('nav_module_label');?></label>
				<?php echo form_dropdown('module_name', array(lang('nav_link_module_select_default'))+$modules_select, $navigation_link->module_name) ?>
			</div>

			<div id="navigation-uri" style="<?php echo @$navigation_link->link_type == 'uri' ? '' : 'display:none'; ?>">
				<label for="uri"><?php echo lang('nav_uri_label');?></label>
				<input type="text" id="uri" name="uri" value="<?php echo $navigation_link->uri; ?>" />
			</div>

			<div id="navigation-page" style="<?php echo @$navigation_link->link_type == 'page' ? '' : 'display:none'; ?>">
				<label for="page_id"><?php echo lang('nav_page_label');?></label>
				<select name="page_id">
					<option value=""><?php echo lang('nav_link_page_select_default');?></option>
					<?php create_tree_select($pages_select, 0, 0, $navigation_link->page_id); ?>
				</select>
			</div>
		</li>

		<li class="even">
			<label for="target"><?php echo lang('nav_target_label'); ?></label>
			<?php echo form_dropdown('target', array('_self'=> lang('nav_link_target_self'), '_blank' => lang('nav_link_target_blank')), $navigation_link->target); ?>
		</li>

		<li>
			<label for="class"><?php echo lang('nav_class_label'); ?></label>
			<?php echo form_input('class', $navigation_link->class); ?>
		</li>
	</ul>

	<div style="text-align: right">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
	</div>

<?php echo form_close(); ?>
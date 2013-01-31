<div id="details-container">
	<?php if ($this->method == 'create'): ?>
		<div class="hidden" id="title-value-<?php echo $link->navigation_group_id ?>">
			<?php echo lang('nav:link_create_title');?>
		</div>
	<?php else: ?>
		<div class="hidden" id="title-value-<?php echo $link->navigation_group_id ?>">
			<?php echo sprintf(lang('nav:link_edit_title'), $link->title);?>
		</div>
	<?php endif ?>
	
	<?php echo form_open(uri_string(), 'id="nav-' . $this->method . '" class="form_inputs"') ?>
	
		<ul>
<?php if ($this->method == 'edit'): ?>
			<?php echo form_hidden('link_id', $link->id) ?>
<?php endif ?>

			<?php echo form_hidden('current_group_id', $link->navigation_group_id) ?>
			
			<li class="<?php echo alternator('', 'even') ?>">
				<label for="title"><?php echo lang('global:title');?> <span>*</span></label>
				<?php echo form_input('title', $link->title, 'maxlength="50" class="text"') ?>
			</li>
			
			<?php if ($this->method == 'edit'): ?>
				<li class="<?php echo alternator('', 'even') ?>">
					<label for="navigation_group_id"><?php echo lang('nav:group_label');?></label>
					<?php echo form_dropdown('navigation_group_id', $groups_select, $link->navigation_group_id) ?>
				</li>
			<?php else: ?>
				<?php echo form_hidden('navigation_group_id', $link->navigation_group_id) ?>
			<?php endif ?>
	
			<li class="<?php echo alternator('', 'even') ?>">
				<label for="link_type"><?php echo lang('nav:type_label');?></label>
				<span class="spacer-right">
					<?php echo form_radio('link_type', 'url', $link->link_type == 'url') ?> <?php echo lang('nav:url_label');?>
					<?php echo form_radio('link_type', 'uri', $link->link_type == 'uri') ?> <?php echo lang('nav:uri_label');?>
					<?php echo form_radio('link_type', 'module', $link->link_type == 'module') ?> <?php echo lang('nav:module_label');?>
					<?php echo form_radio('link_type', 'page', $link->link_type == 'page') ?> <?php echo lang('nav:page_label');?>
				</span>
			</li>

			<li class="<?php echo alternator('', 'even') ?>">
	
				<p style="<?php echo ! empty($link->link_type) ? 'display:none' : '' ?>">
					<?php echo lang('nav:link_type_desc') ?>
				</p>
	
				<div id="navigation-url" style="<?php echo @$link->link_type == 'url' ? '' : 'display:none' ?>">
					<label class="label" for="url"><?php echo lang('nav:url_label');?></label>
					<input type="text" id="url" name="url" value="<?php echo empty($link->url) ? 'http://' : $link->url ?>" />
				</div>
	
				<div id="navigation-module" style="<?php echo @$link->link_type == 'module' ? '' : 'display:none' ?>">
					<label class="label" for="module_name"><?php echo lang('nav:module_label');?></label>
					<?php echo form_dropdown('module_name', array(lang('nav:link_module_select_default'))+$modules_select, $link->module_name) ?>
				</div>
	
				<div id="navigation-uri" style="<?php echo @$link->link_type == 'uri' ? '' : 'display:none' ?>">
					<label class="label" for="uri"><?php echo lang('nav:uri_label');?></label>
					<input type="text" id="uri" name="uri" value="<?php echo $link->uri ?>" />
				</div>
	
				<div id="navigation-page" style="<?php echo @$link->link_type == 'page' ? '' : 'display:none' ?>">
					<label class="label" for="page_id"><?php echo lang('nav:page_label');?></label>
					<select name="page_id">
						<option value=""><?php echo lang('global:select-pick');?></option>
						<?php echo $tree_select ?>
					</select>
				</div>
			</li>

			<li class="<?php echo alternator('', 'even') ?>">
				<label for="target"><?php echo lang('nav:target_label') ?></label>
				<?php echo form_dropdown('target', array(''=> lang('nav:link_target_self'), '_blank' => lang('nav:link_target_blank')), $link->target) ?>
			</li>

			<li class="<?php echo alternator('even', '') ?>">
				<label for="restricted_to[]"><?php echo lang('nav:restricted_to');?></label>
				<?php echo form_multiselect('restricted_to[]', array(0 => lang('global:select-any')) + $group_options, $link->restricted_to, 'size="'.(($count = count($group_options)) > 1 ? $count : 2).'"') ?>
			</li>
	
			<li class="<?php echo alternator('', 'even') ?>">
				<label for="class"><?php echo lang('nav:class_label') ?></label>
				<?php echo form_input('class', $link->class) ?>
			</li>
		</ul>
	
		<div class="buttons float-left padding-top">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
		</div>
	
	<?php echo form_close() ?>
</div>
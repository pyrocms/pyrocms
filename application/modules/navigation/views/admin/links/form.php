<? if($this->uri->segment(3,'create') == 'create'): ?>
	<h3><?=lang('nav_link_create_title');?></h3>	
<? else: ?>
	<h3><?=sprintf(lang('nav_link_edit_title'), $this->data->navigation_link->title);?></h3>
<? endif; ?>
<?= form_open($this->uri->uri_string()); ?>

	<fieldset>
		<legend><?=lang('nav_details_label');?></legend>
			
		<div class="field">
			<label for="title"><?=lang('nav_text_label');?></label>
			<input type="text" id="title" name="title" maxlength="50" value="<?= $navigation_link->title; ?>" />
		</div>
			
		<div class="field">
			<label for="navigation_group_id"><?=lang('nav_group_label');?></label>
			<?=form_dropdown('navigation_group_id', $groups_select, $navigation_link->navigation_group_id, 'size="'.count($groups_select).'"') ?>
		</div>
			
		<div class="field">
			<label for="position"><?=lang('nav_position_label');?></label>
			<input type="text" id="position" name="position" value="<?= $navigation_link->position; ?>" />
		</div>
			
	</fieldset>
	
	<fieldset>
		<legend><?=lang('nav_location_label');?></legend>	
		<p><?=lang('nav_link_type_desc');?></p>
			
		<div class="field float-left">
			<label for="url"><?=lang('nav_url_label');?></label>
			<input type="text" id="url" name="url" value="<?= empty($navigation_link->url) ? 'http://' : $navigation_link->url; ?>" />
		</div>
			
		<div class="field float-left">
			<label for="module_name"><?=lang('nav_module_label');?></label>
			<?=form_dropdown('module_name', array(lang('nav_link_module_select_default'))+$modules_select, $navigation_link->module_name) ?>
		</div>
		
		<div class="field float-left">
			<label for="uri"><?=lang('nav_uri_label');?></label>
			<input type="text" id="uri" name="uri" value="<?= $navigation_link->uri; ?>" />
		</div>
		
		<div class="field float-left">
			<label for="page_id"><?=lang('nav_page_label');?></label>
			<select name="page_id">
				<option value=""><?=lang('nav_link_page_select_default');?></option>
				<? create_tree_select($pages_select, 0, 0, $navigation_link->page_id); ?>
			</select>
		</div>
		
	</fieldset>
	
	<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?= form_close(); ?>
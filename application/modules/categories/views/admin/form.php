<? if($this->uri->segment(3,'create') == 'create'): ?>
	<h2><?=lang('cat_create_title');?></h2>	
<? else: ?>
	<h2><?=sprintf(lang('cat_edit_title'), $this->data->category->title);?></h2>
<? endif; ?>
<?= form_open($this->uri->uri_string()); ?>
	<div class="field">
		<label for="title"><?=lang('cat_title_label');?></label>
		<?= form_input('title', $category->title, 'class="text"'); ?>
		<span class="required-icon tooltip"><?=lang('cat_required_label');?></span>
	</div>
	<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?= form_close(); ?>
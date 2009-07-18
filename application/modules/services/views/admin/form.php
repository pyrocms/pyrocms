<? if($this->uri->segment(3,'create') == 'create'): ?>
	<h3><?=lang('service_create_title');?></h3>	
<? else: ?>
	<h3><?=sprintf(lang('service_edit_title'), $service->title);?></h3>
<? endif; ?>

<?= form_open($this->uri->uri_string()); ?>

	<div class="field">
		<label for="title"><?=lang('service_title_label');?></label>
		<?= form_input('title', $service->title, 'class="text"'); ?>
	</div>
	
	<div class="field">
		<label for="price"><?=lang('service_price_label');?> (<?= $this->settings->item('currency');?>)</label>
		<?= form_input('price', $service->price, 'class="text width-5"'); ?> <?=form_dropdown('pay_per', $pay_per_options, $service->pay_per) ?>
	</div>
	
	<div class="field">
		<label for="description"><?=lang('service_desc_label');?></label>
		<?=form_textarea(array('id'=>'description', 'name'=>'description', 'value' => $service->description, 'rows' => 10, 'class'=>'wysiwyg-simple')); ?>
	</div>
	
	<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?= form_close(); ?>
<? if($this->uri->segment(3,'create') == 'create'): ?>
	<h3>Create service</h3>
	
<? else: ?>
	<h3>Edit service "<?= $service->title; ?>"</h3>
<? endif; ?>

<?= form_open($this->uri->uri_string()); ?>

<div class="field">
	<label for="title">Title</label>
	<?= form_input('title', $service->title, 'class="text"'); ?>
</div>

<div class="field">
	<label for="price">Price (<?= $this->settings->item('currency');?>)</label>
	<?= form_input('price', $service->price, 'class="text width-5"'); ?> <?=form_dropdown('pay_per', $pay_per_options, $service->pay_per) ?>
</div>

<div class="field">
	<label for="description">Description</label>
	<?= $this->spaw->show(); ?>
</div>

<? $this->load->view('admin/layout_fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>

<?= form_close(); ?>
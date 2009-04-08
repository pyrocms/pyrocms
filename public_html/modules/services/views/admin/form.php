<? if($this->uri->segment(3,'create') == 'create'): ?>
	<h3>Create service</h3>
	
<? else: ?>
	<h3>Edit service "<?= $service->title; ?>"</h3>
<? endif; ?>

<?=$this->load->view('admin/result_messages') ?>

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

<p>
	<input type="image" name="btnSave" value="Save" src="/assets/img/admin/fcc/btn-save.jpg" />
	or
	<span class="fcc-cancel"><?= anchor('admin/services/index', 'Cancel'); ?></span>
</p>

<?= form_close(); ?>
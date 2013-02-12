<div class="accordion-group">
<section class="title accordion-heading">
	<?php if ($this->controller == 'admin_categories' && $this->method === 'edit'): ?>
	<h4><?php echo sprintf(lang('cat:edit_title'), $category->title);?></h4>
	<?php else: ?>
	<h4><?php echo lang('cat:create_title');?></h4>
	<?php endif ?>
</section>


<section class="accordion-body collapse in lstnav">
<div class="content">
<?php echo form_open($this->uri->uri_string(), 'class="crud'.((isset($mode)) ? ' '.$mode : '').'" id="categories"') ?>

<div class="form_inputs">

	<ul>
		<li class="even">
			<label for="title"><?php echo lang('global:title');?> <span>*</span></label>
			<div class="input"><?php echo  form_input('title', $category->title) ?></div>
			<label for="slug"><?php echo lang('global:slug') ?> <span>*</span></label>
			<div class="input"><?php echo  form_input('slug', $category->slug) ?></div>
			<?php echo  form_hidden('id', $category->id) ?>
		</li>
	</ul>

</div>

	<div><?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?></div>

<?php echo form_close() ?>
</div>
</section>
</div>
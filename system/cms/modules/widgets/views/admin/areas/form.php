<section class="title">
	<h4><?php echo lang(sprintf('widgets:%s_area', ($this->method === 'create' ? 'add' : 'edit'))) ?></h4>
</section>

<section class="item">
	<div class="content">

	<?php echo form_open(uri_string(), 'class="form_inputs"') ?>
	
	<ul>
		<li>
			<label for="title"><?php echo lang('widgets:widget_area_title') ?></label>
			<?php echo form_input('title', $area->title, 'class="new-area-title"') ?>
			<span class="required-icon tooltip"><?php echo lang('required_label') ?></span>
		</li>
	
		<li class="even">
			<label for="slug"><?php echo lang('widgets:widget_area_slug') ?></label>
			<?php echo form_input('slug', $area->slug, 'class="new-area-slug"') ?>
			<span class="required-icon tooltip"><?php echo lang('required_label') ?></span>
		</li>
	
	</ul>
	
	<div class="buttons align-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))) ?>
	</div>
	
	<?php echo form_close() ?>
	
	</div>
</section>
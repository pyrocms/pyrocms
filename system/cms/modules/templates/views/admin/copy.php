<section class="title">
	<h4><?php echo sprintf(lang('templates:clone_title'), $template_name) ?></h4>
</section>
<?php echo form_open(current_url(), 'class="crud"') ?>
<section class="item">
	<div class="content">
		<ul>
			<li class="even">
			    <label for="lang"><?php echo lang('templates:choose_lang_label') ?></label>
			    <?php echo form_dropdown('lang', $lang_options) ?>
			</li>
		</ul>
		<div class="buttons alignright padding-top">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
		</div>
		<?php echo form_close() ?>
	</div>
</section>
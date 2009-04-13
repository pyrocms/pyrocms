<ul class="settings-tabs padding-bottom">
	<li><?=anchor('admin/settings', 'General', $current_section_slug == '' ? array('class'=>'current') : '') ?></li>
	<? foreach($setting_sections as $section_slug => $section_name): ?>
	<li><?=anchor('admin/settings/section/'.$section_slug, $section_name, $current_section_slug == $section_slug ? array('class'=>'current') : '') ?></li>
	<? endforeach; ?>
</ul>

<hr class="clear-both" />

<?= form_open('admin/settings/edit'.($current_section_slug == '' ? '' : '/section/'.$current_section_slug));?>

<? foreach($settings as $setting): ?>
<div class="float-left width-half" style="min-height:7em">
		<label for="<?= $setting->slug; ?>"><?= $setting->title; ?></label>
		<p class="text-small1"><?= $setting->description; ?></p>
		<?=$setting->form_control; ?>
</div>
<? endforeach; ?>

<hr class="clear-both" />
<? $this->load->view('admin/layout_fragments/table_buttons', array('buttons' => array('save') )); ?>

<?=form_close(); ?>
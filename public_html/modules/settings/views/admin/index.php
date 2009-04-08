<ul class="settings-tabs padding-bottom">
	<li><?=anchor('admin/settings', 'General', $current_section_slug == '' ? array('class'=>'current') : '') ?></li>
	<? foreach($setting_sections as $section_slug => $section_name): ?>
	<li><?=anchor('admin/settings/section/'.$section_slug, $section_name, $current_section_slug == $section_slug ? array('class'=>'current') : '') ?></li>
	<? endforeach; ?>
</ul>

<br class="clear-both" />

    <?=$this->load->view('admin/result_messages') ?>

<?= form_open('admin/settings/edit'.($current_section_slug == '' ? '' : '/section/'.$current_section_slug), 'class="fcc-form"');?>

<? foreach($settings as $setting): ?>
<div class="float-left width-half" style="min-height:7em">
		<label for="<?= $setting->slug; ?>"><?= $setting->title; ?></label>
		<p class="text-small1"><?= $setting->description; ?></p>
		<?=$setting->form_control; ?>
</div>
<? endforeach; ?>

<p class="clear-both">
	<input type="image" name="btnSave" value="Save" src="/assets/img/admin/fcc/btn-save.jpg" />
	or
	<span class="fcc-cancel"><?= anchor('admin', 'Cancel'); ?></span>
</p>

<?=form_close(); ?>
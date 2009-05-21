<?= form_open('admin/settings/edit');?>
<div class="fieldset fieldsetBlock active tabs">
	
	<div class="header">
		<h3>Edit settings</h3>
	</div>
    
    <div class="tabs">
		<ul class="clear-both">
			<? foreach($setting_sections as $section_slug => $section_name): ?>
			<li><a href="#<?=$section_slug;?>" title="<?=$section_name;?> settings"><span><?=$section_name;?></span></a></li>
			<? endforeach; ?>
		</ul>
		
		<? foreach($setting_sections as $section_slug => $section_name): ?>
		
		<fieldset id="<?=$section_slug;?>">
			<legend><?=$section_name;?></legend>
		
			<? $section_count = 1; foreach($settings[$section_slug] as $setting): ?>
			<div class="float-left width-half">
					<label for="<?= $setting->slug; ?>"><?= $setting->title; ?></label>
					<p class="text-small1"><?= $setting->description; ?></p>
					<?=$setting->form_control; ?>
			</div>

			<? if($section_count == 2): $section_count = 0; ?>
			<hr class="clear-both" />
			<? endif; ?>

			<? $section_count++; endforeach; ?>
		
		</fieldset>
		<? endforeach; ?>
		
	</div>
	
</div>
			
<? $this->load->view('admin/layout_fragments/table_buttons', array('buttons' => array('save') )); ?>

<?=form_close(); ?>
<?= form_open('admin/settings/edit');?>
<div class="fieldset fieldsetBlock active tabs">	
	<div class="header">
		<h3><?= lang('settings_edit_title');?></h3>
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
			<div class="field">
					<label for="<?= $setting->slug; ?>"><?= $setting->title; ?></label>
					<div class="float-right width-40">
						<?=$setting->form_control; ?><br/>
						<span class="clear-both text-small1"><?= $setting->description; ?></span>
					</div>
			</div>
			<? $section_count++; endforeach; ?>		
		</fieldset>
		<? endforeach; ?>		
	</div>	
</div>			
<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save') )); ?>
<?=form_close(); ?>
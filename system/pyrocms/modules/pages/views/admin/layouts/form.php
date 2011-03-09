<?php if ($this->method == 'create'): ?>
<h3><?php echo lang('page_layouts.create_title');?></h3>
<?php else: ?>
<h3><?php echo sprintf(lang('page_layouts.edit_title'), $page_layout->title);?></h3>
<?php endif; ?>


<?php echo form_open(uri_string(), 'class="crud"'); ?>

	<div class="tabs">
	
		<ul class="tab-menu">
			<li><a href="#page-layout-html"><span><?php echo lang('page_layouts.html_label');?></span></a></li>
			<li><a href="#page-layout-css"><span><?php echo lang('page_layouts.css_label');?></span></a></li>
			<li><a href="#page-layout-script"><span><?php echo lang('pages.js_label');?></span></a></li>
		</ul>
		
		<div id="page-layout-html">
			<fieldset>
						
				<p><?php echo lang('page_layouts.variable_introduction'); ?>:</p>
				
				<ul class="list-unstyled spacer-bottom">
					<li><strong>{<?php echo config_item('tags_trigger'); ?>:page:title}</strong> - <?php echo lang('page_layouts.variable_title'); ?></li>
					<li><strong>{<?php echo config_item('tags_trigger'); ?>:page:body}</strong> - <?php echo lang('page_layouts.variable_body'); ?></li>
				</ul>
				
				<ul>
					<li class="even">
						<label for="title"><?php echo lang('page_layouts.title_label');?></label>
						<?php echo form_input('title', $page_layout->title, 'maxlength="60"'); ?>
						<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
					</li>

					<li>
						<label for="theme_layout"><?php echo lang('page_layouts.theme_layout_label');?></label>
						<?php echo form_dropdown('theme_layout', $theme_layouts, $page_layout->theme_layout ? $page_layout->theme_layout : 'default'); ?>
					</li>
			
					<li class="even">
						<?php echo form_textarea(array('id'=>'html_editor', 'name'=>'body', 'value' => $page_layout->body, 'rows' => 50)); ?>
					</li>
				</ul>
			</fieldset>
		</div>
		
		<!-- Design tab -->
		<div id="page-layout-css">
			<ul>
				<li>
					<?php echo form_textarea('css', $page_layout->css, 'id="css_editor"'); ?>
				</li>
			</ul>
		</div>
		
		<!-- Script tab -->
		<div id="page-layout-script">
			<ul>
				<li>
					<?php echo form_textarea('js', $page_layout->js, 'id="js_editor"'); ?>
				</li>
			</ul>
		</div>
		
	</div>
	
	<div class="buttons float-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
	</div>

<?php echo form_close(); ?>
		

<script type="text/javascript">
	html_editor('html_editor', '100%');
	css_editor('css_editor', '100%');
	js_editor('js_editor', '100%');
</script>
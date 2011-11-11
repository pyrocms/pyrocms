<section class="title">
	<?php if ($this->method == 'create'): ?>
	<h4><?php echo lang('page_layouts.create_title');?></h4>
	<?php else: ?>
	<h4><?php echo sprintf(lang('page_layouts.edit_title'), $page_layout->title);?></h4>
	<?php endif; ?>
</section>

<section class="item">
	
<?php echo form_open(uri_string(), 'class="crud"'); ?>

	<div class="tabs">
	
		<ul class="tab-menu">
			<li><a href="#page-layout-html"><span><?php echo lang('page_layouts.html_label');?></span></a></li>
			<li><a href="#page-layout-css"><span><?php echo lang('page_layouts.css_label');?></span></a></li>
			<li><a href="#page-layout-script"><span><?php echo lang('pages.js_label');?></span></a></li>
		</ul>
		
		<div class="form_inputs" id="page-layout-html">
		
			<fieldset>
				
				<ul>
					<li class="even">
						<label for="title"><?php echo lang('page_layouts.title_label');?> <span>*</span></label>
						<div class="input"><?php echo form_input('title', $page_layout->title, 'maxlength="60"'); ?></div>
					</li>
					
					<li>
						<label for="theme_layout"><?php echo lang('page_layouts.theme_layout_label');?></label>
						<div class="input"><?php echo form_dropdown('theme_layout', $theme_layouts, $page_layout->theme_layout ? $page_layout->theme_layout : 'default'); ?></div>
					</li>
			
					<li class="even">
						<label for="html_editor"><?php echo lang('page_layouts.layout'); ?></label>
						<?php echo form_textarea(array('id'=>'html_editor', 'name'=>'body', 'value' => $page_layout->body, 'rows' => 50)); ?>
					</li>
				</ul>
				
			</fieldset>
		
		</div>
		
		<!-- Design tab -->
		<div class="form_inputs" id="page-layout-css">
			
			<fieldset>
		
			<ul>
				<li>
					<label for="css">CSS</label><br />
					<?php echo form_textarea('css', $page_layout->css, 'class="css_editor" id="css"'); ?>
				</li>
			</ul>
			
			</fieldset>
			
		</div>
		
		<!-- Script tab -->
		<div class="form_inputs" id="page-layout-script">

			<fieldset>

			<ul>
				<li>
					<label for="js">JavaScript</label><br />
					<?php echo form_textarea('js', $page_layout->js, 'class="js_editor" id="js"'); ?>
				</li>
			</ul>

			</fieldset>

		</div>
		
	</div>
	
	<div class="buttons float-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
	</div>

<?php echo form_close(); ?>
</section>
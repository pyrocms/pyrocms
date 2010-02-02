<?php echo form_open($this->uri->uri_string(), 'class="crud"'); ?>

<div class="box">

	<?php if($method == 'create'): ?>
		<h3><?php echo lang('page_layouts.create_title');?></h3>
	<?php else: ?>
		<h3><?php echo sprintf(lang('page_layouts.edit_title'), $page_layout->title);?></h3>
	<?php endif; ?>
	
	<div class="box-container">	
	
		<div class="tabs">
		
			<ul class="tab-menu">
				<li><a href="#page-layout-html"><span><?php echo lang('page_layouts.html_label');?></span></a></li>
				<li><a href="#page-layout-css"><span><?php echo lang('page_layouts.css_label');?></span></a></li>
			</ul>
			
			<div id="page-layout-html">
				<fieldset>
							
					<p><?php echo lang('page_layouts.variable_introduction'); ?>:</p>
					
					<ul class="list-unstyled spacer-bottom">
						<li><strong>{$page.title}</strong> - <?php echo lang('page_layouts.variable_title'); ?></li>
						<li><strong>{$page.body}</strong> - <?php echo lang('page_layouts.variable_body'); ?></li>
					</ul>
					
					<ol>
						<li class="even">
							<label for="title"><?php echo lang('page_layouts.title_label');?></label>
							<?php echo form_input('title', $page_layout->title, 'maxlength="60"'); ?>
						</li>
				
						<li>
							<div style="border:1px solid;">
								<?php echo form_textarea(array('id'=>'html_editor', 'name'=>'body', 'value' => $page_layout->body, 'rows' => 50)); ?>
							</div>
						</li>
					</ol>
				</fieldset>
			</div>
			
			<!-- Design tab -->
			<div id="page-layout-css">
				<ol>	
					<li>
						<div style="border:1px solid;">
							<?php echo form_textarea('css', $page_layout->css, 'id="css_editor"'); ?>
						</div>
					</li>
				</ol>
			</div>
			
		</div>
		
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>

	</div>
</div>

<?php echo form_close(); ?>

<script type="text/javascript">
	html_editor('html_editor', '100%');
	css_editor('css_editor', '100%');
</script>
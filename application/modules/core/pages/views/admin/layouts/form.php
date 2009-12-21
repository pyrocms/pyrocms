<?php echo form_open($this->uri->uri_string(), 'class="crud"'); ?>

<?php if($method == 'create'): ?>
	<h3><?php echo lang('page_layouts.create_title');?></h3>
<?php else: ?>
	<h3><?php echo sprintf(lang('page_layouts.edit_title'), $page_layout->title);?></h3>
<?php endif; ?>

<div class="field">
	<label for="title"><?php echo lang('page_layouts.title_label');?></label>
	<?php echo form_input('title', $page_layout->title, 'maxlength="60"'); ?>
	<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
</div>

<div class="fieldset fieldsetBlock active tabs">	
	<div class="header">		
		<h3>&nbsp;</h3>
	</div>
  	<div class="tabs">
		<ul class="clear-box">
			<li><a href="#fieldset1"><span><?php echo lang('page_layouts.html_label');?></span></a></li>
			<li><a href="#fieldset2"><span><?php echo lang('page_layouts.css_label');?></span></a></li>
		</ul>
		
		<!-- Page content tab -->
		<fieldset id="fieldset1">
			<legend><?php echo lang('page_content_label');?></legend>
			
			<p><?php echo lang('page_layouts.variable_introduction'); ?>:</p>
			<ul class="list-unstyled">
				<li>{$page.title} - <?php echo lang('page_layouts.variable_title'); ?></li>
				<li>{$page.body} - <?php echo lang('page_layouts.variable_body'); ?></li>
			</ul>
			
			<div class="field">
				<?php echo form_textarea(array('id'=>'html_editor', 'name'=>'body', 'value' => $page_layout->body, 'rows' => 50)); ?>
			</div>
		</fieldset>
		
		<!-- Design tab -->
		<fieldset id="fieldset2">
			<legend><?php echo lang('page_content_label');?></legend>
					
			<div class="field">
				<?php echo form_textarea(array('id'=>'css_editor', 'name'=>'css', 'value' => $page_layout->css, 'rows' => 50)); ?>
			</div>
		</fieldset>
		
	</div>
</div>


<?php $this->load->view('admin/partials/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?php echo form_close(); ?>

<script type="text/javascript">
	html_editor('html_editor', '100%');
	css_editor('css_editor', '100%');
</script>
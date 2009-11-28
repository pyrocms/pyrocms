<?php echo form_open($this->uri->uri_string()); ?>

<?php if($method == 'create'): ?>
	<h3><?php echo lang('page_layout_create_title');?></h3>
<?php else: ?>
	<h3><?php echo sprintf(lang('page_layout_edit_title'), $page_layout->title);?></h3>
<?php endif; ?>

<div class="field">
	<label for="title"><?php echo lang('page_layout_title_label');?></label>
	<?php echo form_input('title', $page_layout->title, 'maxlength="60"'); ?>
	<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
</div>

<div class="fieldset fieldsetBlock active tabs">	
	<div class="header">		
		<h3>&nbsp;</h3>
	</div>    
  	<div class="tabs">
		<ul class="clear-box">
			<li><a href="#fieldset1"><span><?php echo lang('page_layout_html_label');?></span></a></li>
			<li><a href="#fieldset2"><span><?php echo lang('page_layout_css_label');?></span></a></li>
		</ul>
		
		<!-- Page content tab -->
		<fieldset id="fieldset1">
			<legend><?php echo lang('page_content_label');?></legend>
					
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

	

<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?php echo form_close(); ?>

<script type="text/javascript">
	html_editor('html_editor');
	css_editor('css_editor');
</script>
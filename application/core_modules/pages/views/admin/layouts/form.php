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
		
<div class="field">
	<?php echo form_textarea(array('id'=>'html_editor', 'name'=>'body', 'value' => $page_layout->body, 'rows' => 50)); ?>
</div>

<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?php echo form_close(); ?>

<script type="text/javascript">
CodeMirror.fromTextArea('html_editor', {
    height: "30em",
    width: "100%",
    parserfile: ["parsexml.js", "parsecss.js", "parsehtmlmixed.js"],
    stylesheet: [APPPATH_URI + "assets/css/codemirror/xmlcolors.css", APPPATH_URI + "assets/css/codemirror/csscolors.css"],
    path: APPPATH_URI + "assets/js/codemirror/",
    tabMode: 'spaces'
});
</script>
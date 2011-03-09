<?php if($this->method == 'edit' and !empty($email_template)): ?>
    <h4><?php echo $email_template->name; ?></h4>
<?php else: ?>
    <h4>Create Template</h4>
<?php endif; ?>

<?php echo form_open(current_url(), 'class="crud"'); ?>

<ul>
    <?php if(!$email_template->is_default): ?>
    <li>
        <label for="name">Name</label>
        <?php echo form_input('name', $email_template->name); ?>
        <span class="required-icon tooltip">*</span>
    </li>
    <li class="even">
        <label for="slug">Slug</label>
        <?php echo form_input('slug', $email_template->slug); ?>
        <span class="required-icon tooltip">*</span>
    </li>
    <li>
        <label for="lang">Language</label>
        <?php echo form_dropdown('lang', $lang_options, array($email_template->lang)); ?>
    </li>
    <li class="even">
        <label for="description">Description</label>
        <?php echo form_input('description', $email_template->description); ?>
        <span class="required-icon tooltip">*</span>
    </li>
    <?php endif; ?>
    <li>
        <h6>Subject</h6>
        <?php echo form_textarea('subject', $email_template->subject, 'class="wysiwyg-simple"'); ?>
    </li>
    <li>
        <h6>Body</h6>
        <?php echo form_textarea('body', $email_template->body, 'class="wysiwyg-advanced"'); ?>
    </li>
</ul>
<div class="buttons float-right padding-top">
	<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
</div>

<?php echo form_close(); ?>
<?php if ($this->method == 'create'): ?>
<h3><?php echo lang('tag_create_title');?></h3>

<?php else: ?>
<h3><?php echo sprintf(lang('tag_edit_title'), $tag->tag);?></h3>

<?php endif; ?>

<?php echo form_open($this->uri->uri_string(), 'class="crud" id="tags"'); ?>

<fieldset>
    <ol>
        <li class="even">
        <label for="title">
            <?php echo lang('tag_title_label');?>
            <?php if ($this->method == 'create'): ?>                
                <?php echo lang('tag_title_label_multiple');?>
            <?php endif; ?>
        </label>
        <?php echo  form_input('tag', $tag->tag); ?>
        <span class="required-icon tooltip"><?php echo lang('required_label');?></span>
        </li>
    </ol>

    <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
</fieldset>

<?php echo form_close(); ?>
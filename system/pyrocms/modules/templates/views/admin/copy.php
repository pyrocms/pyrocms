<h3>Cloning <?php echo $template_name; ?></h3>

<?php echo form_open(current_url(), 'class="crud"'); ?>

<ul>
    <li>
        <label for="lang">Choose Language</label>
        <?php echo form_dropdown('lang', $lang_options); ?>
    </li>
</ul>
<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
<?php echo form_close();
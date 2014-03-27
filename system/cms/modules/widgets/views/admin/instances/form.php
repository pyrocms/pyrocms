<?php echo form_open(); ?>

<header>
    <h3><?php echo $widget->name ?></h3>
</header>

<?php if ($instance): ?>
    <?php echo form_hidden('id', $instance->id); ?>
<?php endif; ?>

<?php echo form_hidden('widget_id', $widget->id); ?>

<?php if (!empty($error)): ?>
    <?php echo $error; ?>
<?php endif; ?>

<ol>
    <li>
        <label for="name"><?php echo lang('name_label') ?>:</label>
        <?php echo form_input('name', set_value('name', $instance->name)); ?>
        <span class="required-icon tooltip"><?php echo lang('required_label'); ?></span>
    </li>

    <li>
        <label for="show_title"><?php echo lang('widgets:show_title') ?>:</label>
        <?php echo form_checkbox(
            'show_title',
            true,
            isset($widget->options['show_title']) ? $widget->options['show_title'] : false
        ) ?>
    </li>

    <?php if (isset($areas)): ?>
        <li>
            <label for="widget_area_id"><?php echo lang('widgets:widget_area') ?>:</label>
            <?php echo form_dropdown('widget_area_id', $areas, $widget->widget_area_id); ?>
        </li>
    <?php endif; ?>
</ol>

<?php echo $form ? : ''; ?>

<div id="instance-actions" class="buttons buttons-small">
    <?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))); ?>
</div>

<?php echo form_close(); ?>

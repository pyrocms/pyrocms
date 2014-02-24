<div class="widget <?php echo $instance->slug ?>">
    <?php if ($instance->options['show_title']): ?>
        <h3><?php echo $instance->title ?></h3>
    <?php endif ?>

    <?php echo $instance->body ?>
    <div class="divider"></div>
</div>

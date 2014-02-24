<?php if (!empty($filters)): ?>
    <section id="filters">

        <?php echo form_open(null, array('method' => 'post', 'class' => 'form-inline')); ?>

        <?php foreach ($filters as $filter): ?>
            <?php if ($field = $assignments->findBySlug($filter)): ?>
                <?php echo $field->getType()->setStream($stream)->setAppliedFilters($appliedFilters)->filterInput(); ?>
            <?php endif; ?>
        <?php endforeach; ?>


        <button class="button green" type="submit"
                name="<?php echo 'filter-' . $stream->stream_namespace . '-' . $stream->stream_slug; ?>"
                value="apply">
            <?php echo lang('buttons:filter'); ?>
        </button>

        <?php if ($appliedFilters): ?>
        <button class="button" type="submit"
                name="<?php echo 'filter-' . $stream->stream_namespace . '-' . $stream->stream_slug; ?>"
                value="clear">
            <?php echo lang('buttons:clear'); ?>
        </button>
        <?php endif; ?>

        <br/><br/>

        <?php echo form_close(); ?>

    </section>
<?php endif;

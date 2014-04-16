<?php if (!empty($filters)): ?>
    <section id="filters">

        <?php echo form_open(null, array('method' => 'post', 'class' => 'form-inline')); ?>

        <?php foreach ($filters as $filter): ?>
                <?php if (is_array($filter)): ?>
                    <?php if (! isset($filter['type']) or $filter['type'] == 'text'): ?>
                        <?php echo form_input($filter['slug'], isset($appliedFilters[$filterClass->getPostDataFilterKey($filter['slug'])]) ? $appliedFilters[$filterClass->getPostDataFilterKey($filter['slug'])] : null, 'placeholder="'.lang_label($filter['title']).'" class="form-control"'); ?>
                    <?php endif; ?>
                    <?php if ($filter['type'] == 'select'): ?>
                        <?php echo form_dropdown($filter['slug'], $filter['options'], isset($appliedFilters[$filterClass->getPostDataFilterKey($filter['slug'])]) ? $appliedFilters[$filterClass->getPostDataFilterKey($filter['slug'])] : null, 'class=""'); ?>
                    <?php endif; ?>
                <?php else: ?>
                    <?php if ($assignments->findBySlug($filter)): ?>
                        <?php echo $assignments->findBySlug($filter)->getType()->setStream($stream)->setAppliedFilters($appliedFilters)->filterInput(); ?>
                    <?php else: ?>
                        <input type="text" name="f-<?php echo $stream->stream_namespace.'-'.$stream->stream_slug.'-'.$filter.'-contains'; ?>" value="<?php echo isset($appliedFilters[$filterClass->getPostDataFilterKey($filter).'-contains']) ? $appliedFilters[$filterClass->getPostDataFilterKey($filter).'-contains'] : null; ?>" class="form-control" placeholder="<?php echo humanize($filter); ?>">
                    <?php endif; ?>
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

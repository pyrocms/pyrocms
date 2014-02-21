<section class="filters p m-t margin-bottom">

	<?php echo form_open(null, array('method' => 'post', 'class' => 'form-inline', 'id' => 'filters-'.$stream->stream_namespace.'-'.$stream->stream_slug)); ?>

    <div class="hidden">
        <?php echo form_dropdown('limit-'.$stream->stream_namespace.'-'.$stream->stream_slug, array(5 => 5, 10 => 10, 25 => 25, 50 => 50, 100 => 100), ci()->input->get('limit-'.$stream->stream_namespace.'-'.$stream->stream_slug) ?: Settings::get('records_per_page'), 'class="skip" id="limit-'.$stream->stream_namespace.'-'.$stream->stream_slug.'"'); ?>
    </div>

		<?php foreach ($filters as $filter): ?>

			<div class="form-group">
                <?php if (is_array($filter)): ?>
                    <?php if (! isset($filter['type']) or $filter['type'] == 'text'): ?>
                        <?php echo form_input($filter['slug'], isset($appliedFilters[$filter['slug']]) ? $appliedFilters[$filter['slug']] : null, 'placeholder="'.lang_label($filter['title']).'" class="form-control"'); ?>
                    <?php endif; ?>
                    <?php if ($filter['type'] == 'select'): ?>
                        <?php echo form_dropdown($filter['slug'], $filter['options'], isset($appliedFilters[$filter['slug']]) ? $appliedFilters[$filter['slug']] : null, 'class=""'); ?>
                    <?php endif; ?>
                <?php else: ?>
    				<?php if ($assignments->findBySlug($filter)): ?>
    					<?php echo $assignments->findBySlug($filter)->getType()->setStream($stream)->setAppliedFilters($appliedFilters)->filterInput(); ?>
    				<?php else: ?>
    					<input type="text" name="f-<?php echo $stream->stream_namespace.'-'.$stream->stream_slug.'-'.$filter.'-contains'; ?>" value="<?php echo ci()->input->get('f-'.$stream->stream_namespace.'-'.$stream->stream_slug.'-'.$filter.'-contains'); ?>" class="form-control" placeholder="<?php echo humanize($filter); ?>">
    				<?php endif; ?>
                <?php endif; ?>
			</div>

		<?php endforeach; ?>

		<div class="form-group">

            <button class="btn btn-success" type="submit"
                    name="<?php echo 'filter-' . $stream->stream_namespace . '-' . $stream->stream_slug; ?>"
                    value="apply">
                <?php echo lang('buttons:filter'); ?>
            </button>

            <?php if ($appliedFilters): ?>
                <button class="btn btn-danger" type="submit"
                        name="<?php echo 'filter-' . $stream->stream_namespace . '-' . $stream->stream_slug; ?>"
                        value="clear">
                    <?php echo lang('buttons:clear'); ?>
                </button>
            <?php endif; ?>

		</div>

	<?php echo form_close(); ?>

</section>

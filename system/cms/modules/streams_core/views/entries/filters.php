<section class="filters p m-t margin-bottom">

	<?php echo form_open(null, array('method' => 'get', 'class' => 'form-inline'), array('filter-'.$stream->stream_namespace.'-'.$stream->stream_slug => 'y')); ?>

		<?php foreach ($filters as $filter): ?>

			<div class="form-group">
                <?php if (is_array($filter)): ?>
                    <?php if (! isset($filter['type']) or $filter['type'] == 'text'): ?>
                        <?php echo form_input($filter['slug'], ci()->input->get($filter['slug']), 'placeholder="'.lang_label($filter['title']).'" class="form-control"'); ?>
                    <?php endif; ?>
                    <?php if ($filter['type'] == 'select'): ?>
                        <?php echo form_dropdown($filter['slug'], $filter['options'], ci()->input->get($filter['slug']), 'class=""'); ?>
                    <?php endif; ?>
                <?php else: ?>
    				<?php if ($stream_fields->findBySlug($filter)): ?>
    					<?php echo $stream_fields->findBySlug($filter)->getType()->setStream($stream)->filterInput(); ?>
    				<?php else: ?>
    					<input type="text" name="f-<?php echo $stream->stream_namespace.'-'.$stream->stream_slug.'-'.$filter.'-contains'; ?>" value="<?php echo ci()->input->get('f-'.$stream->stream_namespace.'-'.$stream->stream_slug.'-'.$filter.'-contains'); ?>" class="form-control" placeholder="<?php echo humanize($filter); ?>">
    				<?php endif; ?>
                <?php endif; ?>
			</div>

		<?php endforeach; ?>
		
		<div class="form-group">

			<div>
				<button class="btn btn-success"><?php echo lang('buttons:filter'); ?></button>
				<a class="btn btn-default clear-filters" href="<?php echo site_url(uri_string()); ?>"><?php echo lang('buttons:clear'); ?></a>
			</div>
			
		</div>

	<?php echo form_close(); ?>

</section>
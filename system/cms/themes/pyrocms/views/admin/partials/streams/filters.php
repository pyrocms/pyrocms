<section class="filters padding margin-top margin-bottom">

	<?php echo form_open(null, array('method' => 'get', 'class' => 'form-inline'), array('filter-'.$stream->stream_namespace.'-'.$stream->stream_slug => 'y')); ?>

		<?php foreach ($filters as $filter): ?>

			<div class="form-group">
				<!--<label for="exampleInputEmail2">Email address</label>-->
				<?php echo $stream_fields->findBySlug($filter)->getFilterOutput(); ?>
			</div>

		<?php endforeach; ?>
		
		<div class="form-group">
			<!--<label>&nbsp;</label>-->
			<div>
				<button class="btn btn-success"><?php echo lang('buttons:filter'); ?></button>
				<a class="btn btn-default" href="<?php echo site_url(uri_string()); ?>"><?php echo lang('buttons:clear'); ?></a>
			</div>
		</div>

	<?php echo form_close(); ?>

</section>
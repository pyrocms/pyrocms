<?php if (! empty($filters)): ?>
<section id="filters">

	<?php echo form_open(null, array('method' => 'get', 'class' => 'form-inline'), array('filter-'.$stream->stream_namespace.'-'.$stream->stream_slug => 'y')); ?>

		<?php foreach ($filters as $filter): ?>

			<?php if ($field = $assignments->findBySlug($filter)) echo $field->getType()->setStream($stream)->filterInput(); ?>

		<?php endforeach; ?>
		
		
		<button class="button green"><?php echo lang('buttons:filter'); ?></button>
		<a class="button" href="<?php echo site_url(uri_string()); ?>"><?php echo lang('buttons:clear'); ?></a>

		<br/><br/>

	<?php echo form_close(); ?>

</section>
<?php endif; ?>
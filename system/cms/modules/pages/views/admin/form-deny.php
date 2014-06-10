<section class="title">
	<?php if ($this->method == 'create'): ?>
		<h4><?php echo lang('pages:create_title') ?></h4>
	<?php else: ?>
		<h4><?php echo sprintf(lang('pages:edit_title'), $page->title) ?></h4>
	<?php endif ?>
</section>

<section class="item">
	<div class="content">
		<div class="alert error"><a href="#" class="close"></a>
			<p>You do not have permission to edit this page.</p>
		</div>
	</div>
</section>
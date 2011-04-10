<h3><?php echo lang('pages.list_title'); ?></h3>

<div class="box-container">

	<div id="page-list">
		<ol class="sortable">

			<?php foreach($pages as $page): ?>
	
					<li id="page_<?php echo $page['id']; ?>">
						<div>
							<a href="#" rel="<?php echo $page['id']; ?>"><?php echo $page['title']; ?></a>
						</div>
				
				<?php if(isset($page['children'])): ?>
						<ol>
							<?php $controller->tree_builder($page); ?>
						</ol>
					</li>
				<?php else: ?>
					</li>
				<?php endif; ?>
				
			<?php endforeach; ?>

		</ol>
	</div>
	
	<div id="page-details">
	
		<p>
			<?php echo lang('pages.tree_explanation'); ?>
		</p>
	
	</div>
	
	<br class="clear-both" />
	
</div>
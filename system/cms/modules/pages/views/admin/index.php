<div class="one_half">
	<section class="title">
		<h4><?php echo lang('pages.list_title'); ?></h4>
	</section>
	
	<section class="item">
		<div id="page-list">
		<ul class="sortable">

			<?php foreach($pages as $page): ?>
	
					<li id="page_<?php echo $page['id']; ?>">
						<div>
							<a href="#" rel="<?php echo $page['id']; ?>"><?php echo $page['title']; ?></a>
						</div>
				
					<?php if(isset($page['children'])): ?>
						<ul>
							<?php $controller->tree_builder($page); ?>
						</ul>
					</li>
				
					<?php else: ?>
					
					</li>
				
				<?php endif; ?>
			<?php endforeach; ?>

		</ul>
		</div>
	</section>
</div>

<div class="one_half last">	
	<section class="title">
		<h4>Explanation</h4>
	</section>
	
	<section class="item">
		<div id="page-details">
		<p>
			<?php echo lang('pages.tree_explanation'); ?>
		</p>
		</div>
	</section>
</div>
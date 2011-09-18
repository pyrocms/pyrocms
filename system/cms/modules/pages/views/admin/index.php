<div class="two_third">
	<section class="title">
		<h4><?php echo lang('pages.list_title'); ?></h4>
	</section>
	
	<section class="item">
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
	</section>
</div>

<div class="one_third_last">	
	<section class="title">
		<h4>Overview</h4>
	</section>
	
	<section class="item">
		<p>
			<?php echo lang('pages.tree_explanation'); ?>
		</p>
	</section>
</div>
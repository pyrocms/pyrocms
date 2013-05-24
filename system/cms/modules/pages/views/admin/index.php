<section class="content-wrapper">
<div class="container-fluid">


	<div class="row-fluid">


		<div class="span6 box">
			<section class="box-header">
				<span class="title"><?php echo lang('pages:list_title') ?></span>
			</section>
			
			<section class="box-content">
				
				<div id="page-list">
				<ul class="sortable">
					<?php echo tree_builder($pages, '<li id="page_{{ id }}"><div><a href="#" class="{{ status }}" rel="{{ id }}">{{ title }}</a></div>{{ children }}</li>') ?>
				</ul>
				</div>

			</section>
		</div>
		
		
		<div class="span6 box">
			<section class="box-header">
				<span class="title"><?php echo lang('pages:tree_explanation_title') ?></span>
			</section>
			
			<section class="box-content">

				<div id="page-details">
					<p>
						<?php echo lang('pages:tree_explanation') ?>
					</p>
				</div>

			</section>
		</div>


	</div>


</div>
</section>
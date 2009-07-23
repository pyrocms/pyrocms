<!-- Title -->
<div id="page-title" class="b2">
	<h2><?=$module_data['name'] ? $module_data['name'] : lang('cp_title'); ?></h2>
	
	<? if( !empty($toolbar) ): ?>	
	<!-- TitleActions -->
	<div id="titleActions">
		
		<? if( !empty($toolbar['new_item']) ): ?>
		<!-- new item -->
		<div class="newPost actionBlock">
			<a href="<?= site_url($toolbar['new_item']['link']) ?>" class="button">
				<strong><?= $toolbar['new_item']['title'] ?><?= image('admin/icons/add_48.png', NULL, array('alt' => $toolbar['new_item']['title'] .' icon', 'class' => 'icon') ); ?></strong>
			</a>
		</div>
		<!-- /new item -->
		<? endif; ?>
		
		<? if( !empty($toolbar['search']) ): ?>
		<!-- ListSearch -->
		<div class="listSearch actionBlock">
			<div class="search">
				<label for="search">Recherche</label>
				<input type="text" name="search" id="search" class="text" />
			</div>
			
			<div class="submit">
				<button type="submit" id="search-button" class="button"><strong><img src="img/icons/search_48.png" alt="comments" class="icon "/></strong></button>
			</div>
		</div>
		<!-- /ListSearch -->
		<? endif; ?>		
	</div>
	<!-- /TitleActions -->
	<? endif; ?>	
</div>
<!-- Title -->
<? if( !empty($toolbar['links']) ): ?>
<div id="toolbarActions">
	<p>Links:</p>
	<ul>
		<li><a href="#" class="tooltip"><span class="icon icon_Comment"></span><strong>Comments
		(3)</strong></a></li>
		<li><a href="#" class="tooltip"><span class="icon icon_Document"></span>Media</a></li>
		<li><a href="#" class="tooltip"><span class="icon icon_browser_firefox"></span>Something
		else</a></li>
	</ul>
</div>
<? endif; ?>
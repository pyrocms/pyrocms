		
		<li class="delicious"> 
			<a title="Post this story to Delicious" href="http://del.icio.us/post?url=<?=$bookmark['url'];?>&amp;title=<?=urlencode($bookmark['title']);?>">
				<?=image('icons/social_media/shiny_square/64x64/Delicious.png'); ?>
			</a> 
		</li>
		
		<li class="digg"> 
			<a title="Post this story to Digg" href="http://digg.com/submit?url=<?=$bookmark['url'];?>&amp;title=<?=urlencode($bookmark['title']);?>">
				<?=image('icons/social_media/shiny_square/64x64/Digg.png'); ?>
			</a> 
		</li>
		
		<li class="reddit"> 
			<a title="Post this story to reddit" href="http://reddit.com/submit?url=<?=$bookmark['url'];?>&amp;title=<?=urlencode($bookmark['title']);?>">
				<?=image('icons/social_media/shiny_square/64x64/Reddit.png'); ?>
			</a> 
		</li>
		
		<li class="facebook"> 
			<a title="Post this story to Facebook" href="http://www.facebook.com/sharer.php?u=<?=$bookmark['url'];?>">
				<?=image('icons/social_media/shiny_square/64x64/Facebook.png'); ?>
			</a> 
		</li>
		
		<li class="stumbleupon"> 
			<a title="Post this story to StumbleUpon" href="http://www.stumbleupon.com/submit?url=<?=$bookmark['url'];?>&amp;title=<?=urlencode($bookmark['title']);?>">
				<?=image('icons/social_media/shiny_square/64x64/StumbleUpon.png'); ?>
			</a> 
		</li>
		
		<li class="dzone"> 
			<a title="Post this story to DZone" href="http://www.dzone.com/links/add.html?url=<?=$bookmark['url'];?>&amp;title=<?=urlencode($bookmark['title']);?>">
				<?=image('icons/social_media/shiny_square/64x64/DZone.png'); ?>
			</a> 
		</li>
		
		<li class="google"> 
			<a title="Post this story to Google" href="http://www.google.com/bookmarks/mark?op=edit&bkmk=<?=$bookmark['url'];?>&amp;title=<?=urlencode($bookmark['title']);?>">
				<?=image('icons/social_media/shiny_square/64x64/Google.png'); ?>
			</a> 
		</li>
		
		<li class="furl"> 
			<a title="Post this story to Furl" href="http://www.furl.net/storeIt.jsp?t=<?=urlencode($bookmark['title']);?>&amp;u=<?=$bookmark['url'];?>">
				<?=image('icons/social_media/shiny_square/64x64/Furl.png'); ?>
			</a> 
		</li>
		
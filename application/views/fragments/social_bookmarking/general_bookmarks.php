	
		<li class="delicious"> 
			<a title="<?php echo sprintf(lang('sbm_post_to'), 'Delicious');?>" href="http://del.icio.us/post?url=<?php echo $bookmark['url'];?>&amp;title=<?php echo urlencode($bookmark['title']);?>">
				<?php echo image('icons/social_media/shiny_square/64x64/Delicious.png'); ?>
			</a> 
		</li>
		
		<li class="digg"> 
			<a title="<?php echo sprintf(lang('sbm_post_to'), 'Digg');?>" href="http://digg.com/submit?url=<?php echo $bookmark['url'];?>&amp;title=<?php echo urlencode($bookmark['title']);?>">
				<?php echo image('icons/social_media/shiny_square/64x64/Digg.png'); ?>
			</a> 
		</li>
		
		<li class="reddit"> 
			<a title="<?php echo sprintf(lang('sbm_post_to'), 'reddit');?>" href="http://reddit.com/submit?url=<?php echo $bookmark['url'];?>&amp;title=<?php echo urlencode($bookmark['title']);?>">
				<?php echo image('icons/social_media/shiny_square/64x64/Reddit.png'); ?>
			</a> 
		</li>
		
		<li class="facebook"> 
			<a title="<?php echo sprintf(lang('sbm_post_to'), 'Facebook');?>" href="http://www.facebook.com/sharer.php?u=<?php echo $bookmark['url'];?>">
				<?php echo image('icons/social_media/shiny_square/64x64/Facebook.png'); ?>
			</a> 
		</li>
		
		<li class="stumbleupon"> 
			<a title="<?php echo sprintf(lang('sbm_post_to'), 'StumbleUpon');?>" href="http://www.stumbleupon.com/submit?url=<?php echo $bookmark['url'];?>&amp;title=<?php echo urlencode($bookmark['title']);?>">
				<?php echo image('icons/social_media/shiny_square/64x64/StumbleUpon.png'); ?>
			</a> 
		</li>
		
		<li class="dzone"> 
			<a title="<?php echo sprintf(lang('sbm_post_to'), 'DZone');?>" href="http://www.dzone.com/links/add.html?url=<?php echo $bookmark['url'];?>&amp;title=<?php echo urlencode($bookmark['title']);?>">
				<?php echo image('icons/social_media/shiny_square/64x64/DZone.png'); ?>
			</a> 
		</li>
		
		<li class="google"> 
			<a title="<?php echo sprintf(lang('sbm_post_to'), 'Google');?>" href="http://www.google.com/bookmarks/mark?op=edit&bkmk=<?php echo $bookmark['url'];?>&amp;title=<?php echo urlencode($bookmark['title']);?>">
				<?php echo image('icons/social_media/shiny_square/64x64/Google.png'); ?>
			</a> 
		</li>
		
		<li class="twitter"> 
			<a title="<?php echo sprintf(lang('sbm_post_to'), 'Twitter');?>" href="http://twitter.com/home/?source=<?php echo $this->input->server('SERVER_NAME');?>&amp;status=<?php echo urlencode($bookmark['title']);?> <?php echo $bookmark['url'];?>">
				<?php echo image('icons/social_media/shiny_square/64x64/Twitter.png'); ?>
			</a> 
		</li>	
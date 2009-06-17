	
		<li class="delicious"> 
			<a title="<?=sprintf(lang('sbm_post_to'), 'Delicious');?>" href="http://del.icio.us/post?url=<?=$bookmark['url'];?>&amp;title=<?=urlencode($bookmark['title']);?>">
				<?=image('icons/social_media/shiny_square/64x64/Delicious.png'); ?>
			</a> 
		</li>
		
		<li class="digg"> 
			<a title="<?=sprintf(lang('sbm_post_to'), 'Digg');?>" href="http://digg.com/submit?url=<?=$bookmark['url'];?>&amp;title=<?=urlencode($bookmark['title']);?>">
				<?=image('icons/social_media/shiny_square/64x64/Digg.png'); ?>
			</a> 
		</li>
		
		<li class="reddit"> 
			<a title="<?=sprintf(lang('sbm_post_to'), 'reddit');?>" href="http://reddit.com/submit?url=<?=$bookmark['url'];?>&amp;title=<?=urlencode($bookmark['title']);?>">
				<?=image('icons/social_media/shiny_square/64x64/Reddit.png'); ?>
			</a> 
		</li>
		
		<li class="facebook"> 
			<a title="<?=sprintf(lang('sbm_post_to'), 'Facebook');?>" href="http://www.facebook.com/sharer.php?u=<?=$bookmark['url'];?>">
				<?=image('icons/social_media/shiny_square/64x64/Facebook.png'); ?>
			</a> 
		</li>
		
		<li class="stumbleupon"> 
			<a title="<?=sprintf(lang('sbm_post_to'), 'StumbleUpon');?>" href="http://www.stumbleupon.com/submit?url=<?=$bookmark['url'];?>&amp;title=<?=urlencode($bookmark['title']);?>">
				<?=image('icons/social_media/shiny_square/64x64/StumbleUpon.png'); ?>
			</a> 
		</li>
		
		<li class="dzone"> 
			<a title="<?=sprintf(lang('sbm_post_to'), 'DZone');?>" href="http://www.dzone.com/links/add.html?url=<?=$bookmark['url'];?>&amp;title=<?=urlencode($bookmark['title']);?>">
				<?=image('icons/social_media/shiny_square/64x64/DZone.png'); ?>
			</a> 
		</li>
		
		<li class="google"> 
			<a title="<?=sprintf(lang('sbm_post_to'), 'Google');?>" href="http://www.google.com/bookmarks/mark?op=edit&bkmk=<?=$bookmark['url'];?>&amp;title=<?=urlencode($bookmark['title']);?>">
				<?=image('icons/social_media/shiny_square/64x64/Google.png'); ?>
			</a> 
		</li>
		
		<li class="twitter"> 
			<a title="<?=sprintf(lang('sbm_post_to'), 'Twitter');?>" href="http://twitter.com/home/?source=<?=$this->input->server('SERVER_NAME');?>&amp;status=<?=urlencode($bookmark['title']);?> <?=$bookmark['url'];?>">
				<?=image('icons/social_media/shiny_square/64x64/Twitter.png'); ?>
			</a> 
		</li>	
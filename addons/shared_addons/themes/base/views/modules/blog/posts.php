{{ theme:partial name="aside" }}

{{ if posts }}
	{{ posts }}
	
		<article class="post">
			<h5>{{ theme:image file="link.png" }} <a href="{{ url }}">{{ title }}</a></h5>
			
			<div class="post_date">
				<span class="date">
					{{ theme:image file="date.png" }}
					About {{ helper:timespan timestamp=created_on }} ago.
				</span>
			</div>
			
			<hr>
			
			<div class="post_intro">
				{{ intro }}
			</div>
			
			<hr>
			
			<div class="post_meta">
				{{ if keywords }}
					{{ theme:image file="tags.png" }}
					<span class="tags">
						{{ keywords }}
					</span>
				{{ endif }}
			</div>
		</article>

	{{ /posts }}

	{{ pagination }}

{{ else }}
	
	{{ helper:lang line="blog:currently_no_posts" }}

{{ endif }}
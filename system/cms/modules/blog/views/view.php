

{{ post }}

<div class="post">

	<h3>{{ title }}</h3>

	<div class="meta">

		<div class="date">
			{{ helper:lang line="blog:posted_label" }}
			<span>{{ helper:date timestamp=created_on }}</span>
		</div>

		<div class="author">
			{{ helper:lang line="blog:written_by_label" }}
			<span><a href="user/{{ created_by:user_id }}">{{ created_by:display_name }}</a></span>
		</div>

		{{ if category }}
		<div class="category">
			{{ helper:lang line="blog:category_label" }}
			<span><a href="blog/category/{{ category:slug }}">{{ category:title }}</a></span>
		</div>
		{{ endif }}

		{{ if keywords }}
		<div class="keywords">
			{{ keywords }}
				<span><a href="blog/tagged/{{ keyword }}">{{ keyword }}</a></span>
			{{ /keywords }}
		</div>
		{{ endif }}

	</div>

	<div class="body">
		{{ body }}
	</div>

</div>

{{ /post }}

<?php if (Settings::get('enable_comments')): ?>

<div id="comments">

	<div id="existing-comments">
		<h4><?php echo lang('comments:title') ?></h4>
		<?php echo $this->comments->display() ?>
	</div>

	<?php if ($form_display): ?>
		<?php echo $this->comments->form() ?>
	<?php else: ?>
	<?php echo sprintf(lang('blog:disabled_after'), strtolower(lang('global:duration:'.str_replace(' ', '-', $post[0]['comments_enabled'])))) ?>
	<?php endif ?>
</div>

<?php endif ?>

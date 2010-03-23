<div class="section">
	{if count(navigation('sidebar'))}
		<h1>{lang('navigation_headline')}</h1>
		<ul>
			{foreach(navigation('sidebar') nav_link)}
				<li>{anchor($nav_link->url, $nav_link->title,array('target' => $nav_link->target))}</li>
			{/foreach}
		</ul>
		<br />
	{/if}
</div>
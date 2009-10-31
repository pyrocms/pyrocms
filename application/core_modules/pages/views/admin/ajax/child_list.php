<?php foreach($pages as $page):?>
<li>	
	<span class="<?php echo $page->has_children ? 'folder' : 'file' ?>" onclick="javascript:void(0);">
		<?php // <a href="<?php echo site_url('admin/pages/edit/'.$page->id); " rel="page-<?php echo $page->id; " onclick="javascript:window.location = this.href;"> ?>
		<a href="#" rel="page-<?php echo $page->id; ?>">
			<?php echo $page->title; ?> <small>(#<?php echo $page->id; ?>)</small>
		</a>
	</span>
	<?php if ($page->has_children) :?>
		<ul></ul>
	<?php endif;?>
</li>
<?php endforeach;?>

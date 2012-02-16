<section class="title">
	<h4><?php echo lang('files:files_title'); ?></h4>
</section>

<section class="item">
	<section class="one_quarter">
		<?php if ($folders) : ?>

			<ul class="folders-sidebar">
				<li class="places"><?php echo lang('files:places') ?></li>
				<?php foreach ($folders as $folder): ?>
					<li data-slug="<?php echo $folder->slug.'" '.
						(strlen($folder->name) > 20 ? 'title="'.$folder->name.'">'.substr($folder->name, 0, 20).'...' : '>'.$folder->name); ?>
					</li>
				<?php endforeach; ?>
			</ul>

		<?php endif; ?>
	</section>

	<section class="one_half">
		<?php if ($folders) : ?>

			<ul class="folders-right">
				<?php foreach ($folders as $folder): ?>
					<li class="folder" data-slug="<?php echo $folder->slug.'"><span class="folder-text">'.$folder->name; ?></span></li>
				<?php endforeach; ?>
			</ul>

		<?php else : ?>
			<div class="no_data"><?php echo lang('files:no_folders'); ?></div>
		<?php endif; ?>
	</section>

	<section class="right one_quarter">
		<div class="console"></div>
	</section>
</section>
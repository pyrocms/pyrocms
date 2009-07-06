<div class="bInner"><span class="bTR"></span><span class="bBL"></span>
	<ul id="side-nav">
	
		<? foreach($admin_modules as $admin_module): ?>
		<li class="inactive <?= $admin_module['slug']; ?>">
			<a href="<?= site_url('admin/'.$admin_module['slug']); ?>" class="button ajax {title:'Admin | <?=$admin_module['name'];?> | <?=$this->settings->item('site_name');?>'}">
				<strong>
					<?= image('admin/icons/'.(!empty($admin_module['icon']) ? $admin_module['icon'] : 'folder_48.png'), NULL, array('alt' => $admin_module['name'] .' icon', 'class' => 'icon') ); ?>
					<?=$admin_module['name'];?><span class="expand expanded"></span>
				</strong>
			</a>
		</li>
		<? endforeach; ?>
			
	</ul>
</div>
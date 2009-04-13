<div class="bInner"><span class="bTR"></span><span class="bBL"></span>
	<ul id="side-nav">
	
		<? foreach($this->modules_m->getModules(array('is_backend'=>true)) as $module): ?>
		<li class="inactive">
			<a href="<?= site_url('admin/'.$module['slug']); ?>" class="button"><strong><img src="/assets/img/admin/icons/newspaper_48.png" alt="comments" class="icon "/><?=$module['name'];?><span class="expand expanded"></span></strong></a>
		</li>
		<? endforeach; ?>
			
	</ul>
</div>
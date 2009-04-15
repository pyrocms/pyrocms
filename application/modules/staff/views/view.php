
	<h2><?=$staff->name ?></h2>
	<h3><?= $staff->position; ?></h3>

	<a href="<?= image_path('staff/'. $staff->filename); ?>" rel="modal">
	<?= image('staff/' . $staff->filename, '', array('title'=>$staff->name, 'style'=>'width:15em')) ?>
	</a>
	
	<p><?= auto_typography($staff->body); ?></p>
	
	<? if ($staff->fact): ?>
	<p><strong>Random fact:</strong> <?= $staff->fact; ?></p>
	<? endif ?>
		
	<p><a href="<?=site_url('staff'); ?>">&laquo; Back to the team page</a></p>

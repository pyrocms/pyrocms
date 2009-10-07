<h2><?=$staff->name ?></h2>
<h3><?= $staff->position; ?></h3>

<a href="<?= image_path('staff/'. $staff->filename); ?>" rel="modal"><?= image('staff/' . $staff->filename, NULL, array('title'=>$staff->name, 'style'=>'width:15em')) ?></a>

<p><?= auto_typography($staff->body); ?></p>
	
<? if ($staff->fact): ?>
	<p><strong><?= lang('staff_random_fact_label');?>:</strong> <?= $staff->fact; ?></p>
<? endif ?>

<p><a href="<?=site_url('staff'); ?>"><?= lang('staff_back_to_team_page');?></a></p>
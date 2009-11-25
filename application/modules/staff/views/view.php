<h2><?php echo $staff->name ?></h2>
<h3><?php echo $staff->position; ?></h3>

<a href="<?php echo image_path('staff/'. $staff->filename); ?>" rel="modal"><?php echo image('staff/' . $staff->filename, NULL, array('title'=>$staff->name, 'style'=>'width:15em')) ?></a>

<p><?php echo auto_typography($staff->body); ?></p>
	
<?php if ($staff->fact): ?>
	<p><strong><?php echo lang('staff_random_fact_label');?>:</strong> <?php echo $staff->fact; ?></p>
<?php endif ?>

<p><a href="<?php echo site_url('staff'); ?>"><?php echo lang('staff_back_to_team_page');?></a></p>
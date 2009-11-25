<h2><?php echo lang('staff_title');?></h2>
<?php if ($staffs): ?>
	<?php foreach ($staffs as $staff): ?>
		<div class="staffHolder">
			<h3><?php echo anchor('staff/' . $staff->slug, $staff->name); ?></h3>
			<?php echo anchor('staff/' . $staff->slug, image('staff/' . $staff->filename, NULL, array('style'=>'width:15em')), array('title'=>$staff->name)); ?>
			<p>
				<strong><?php echo $staff->position; ?></strong><br/>
				<?php echo word_limiter($staff->body, 50); ?>
			</p>
		</div>
	<?php endforeach; ?>
<?php else: ?>
	<p><?php echo lang('staff_no_members_available');?></p>
<?php endif; ?>
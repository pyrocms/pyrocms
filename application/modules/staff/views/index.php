<h2><?= lang('staff_title');?></h2>
<? if ($staffs): ?>
	<? foreach ($staffs as $staff): ?>
		<div class="staffHolder">
			<h3><?= anchor('staff/' . $staff->slug, $staff->name); ?></h3>
			<?= anchor('staff/' . $staff->slug, image('staff/' . $staff->filename, $staff->name, array('style'=>'width:15em')), array('title'=>$staff->name)); ?>
			<p>
				<strong><?= $staff->position; ?></strong><br/>
				<?= word_limiter($staff->body, 50); ?>
			</p>
		</div>
	<? endforeach; ?>
<? else: ?>
	<p><?= lang('staff_no_members_available');?></p>
<? endif; ?>
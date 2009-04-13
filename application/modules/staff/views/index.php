<h2>Staff</h2>

<? if ($staffs):

	foreach ($staffs as $staff): ?>

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
	<p>We have no staff at the moment.</p>
<? endif; ?>
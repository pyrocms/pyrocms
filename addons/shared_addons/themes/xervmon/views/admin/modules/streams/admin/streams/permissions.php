<div class="accordion-group ">
<section class="accordion-heading">
	<h4><span><a href="<?php echo site_url('admin/streams/manage/'.$stream->id); ?>"><?php echo $stream->stream_name;?></a></span> &rarr; <?php echo $perm_lang;?></h4>
</section>

<section class="item accordion-body collapse in lstnav">
<div class="content">

<?php if ($groups): ?>

<?php echo form_open(uri_string(), 'class="crud"'); ?>

<div class="form_inputs">

	<ul>
	
	<?php foreach ($groups as $group ): ?>

		<li>
			<label for="<?php echo $group->name; ?>"><?php echo $group->description; ?></label>
			<div class="input"><input type="checkbox" name="groups[]" id="<?php echo $group->name; ?>" value="<?php echo $group->group_id; ?>"<?php if (in_array($group->group_id, $permissions)): echo ' checked '; endif; ?>/></div>
		</li>
		
	<?php endforeach; ?>
		
	</ul>
					
</div>

<input type="hidden" name="edited" value="y">

<button type="submit" name="btnAction" value="save" class="btn blue"><span><?php echo lang('buttons:save'); ?></span></button>	
<a href="<?php echo site_url('admin/streams/manage/'.$stream->id); ?>" class="btn gray"><?php echo lang('buttons:cancel'); ?></a>
	
<?php echo form_close();?>

<?php else: ?>

<div class="no_data">No eligible groups found.</div>

<?php endif; ?>

</div>
</section>
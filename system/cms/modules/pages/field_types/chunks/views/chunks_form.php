<ul id="page-chunks">
	<?php $count = 0; foreach ($chunks as $chunk): $chunk = (array)$chunk; ?>
	<li class="page-chunk">
		<?php echo form_input('chunk_slug['.$count.']', $chunk['slug'], 'class="label" placeholder="id"'); ?>
		<?php echo form_input('chunk_class['.$count.']', $chunk['class'], 'class="label" placeholder="class"'); ?>
		<?php echo form_dropdown('chunk_type['.$count.']', array(
			'html' => 'html',
			'markdown' => 'markdown',
			'wysiwyg-simple' => 'wysiwyg-simple',
			'wysiwyg-advanced' => 'wysiwyg-advanced',
		), $chunk['type']); ?>
		<div class="alignright">
			<a href="javascript:void(0)" class="remove-chunk btn red"><?php echo lang('global:remove') ?></a>
			<span class="sort-handle"></span>
		</div>
		<br style="clear:both" />
		<span class="chunky">
			<?php echo form_textarea(array('id' => $chunk['slug'].'_'.$count, 'name'=>'chunk_body['.$count.']', 'value' => $chunk['body'], 'rows' => 20, 'class'=> $chunk['type'])); ?>
		</span>
	</li>
	<?php $count++; endforeach; ?>
</ul>
<a class="add-chunk btn orange" href="#"><?php echo lang('pages:add_page_chunk'); ?></a>

<input type="hidden" name="<?php echo $form_slug; ?>" value="*" />

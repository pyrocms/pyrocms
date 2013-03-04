<script>
(function($){
  pyro.init_ckeditor();
})(jQuery);
</script>
<ul>
	<li class="even">
		<label>HTML</label>
		<?php echo form_textarea(array('name'=>'html', 'value' => $options['html'], 'class' => 'wysiwyg-advanced')); ?>
	</li>
</ul>
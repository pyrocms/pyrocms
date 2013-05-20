<li class="row-fluid input-row streams-param-input">
		<label class="span3" for="<?php echo $input_slug ?>"><?php echo $input_name ?>
	<?php if( isset($instructions) and $instructions ): ?>
		<small><?php echo $instructions ?></small>
	<?php endif ?>
	</label>
	<div class="input span9"><?php echo $input ?></div>
</li>
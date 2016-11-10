<ol>
	<li class="even">
		<label>{{ helper:lang line="blog:num_of_entries" }}</label>
		<?php echo form_input('limit', $options['limit']) ?>
	</li>
		<li class="odd">
			<label>{{ helper:lang line="blog:num_of_characters" }}</label>
			<?php echo form_input('characters', $options['characters']) ?>
		</li>
</ol>
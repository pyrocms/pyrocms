<?php if ( $filters != null ): ?>
<fieldset id="filters">

	<legend><?php echo lang('global:filters'); ?></legend>

	<?php echo form_open('', array('method' => 'get')); ?>

	<ul>  
		<?php foreach ( $filters as $params ): ?>
			<li>
				<?php

					$name = 'f-';

					// Build the name
					if (isset($params['not']) and $params['not']) $name .= 'not-';
					if (isset($params['exact']) and $params['exact']) $name .= 'exact-';

					$name .= $params['field'];


					// Get the value
					$value = end(explode('-', $this->input->get($name)));


					// Dropdown type
					echo '<label>'.lang_label(isset($params['label']) ? $params['label'] : humanize($params['field'])).':&nbsp;</label>';

					if ( isset($params['options']) )
					{
						echo form_dropdown(
							$name,
							$params['options'],
							$value
							);
					}
					else
					{
						echo form_input(
							$name,
							$value
							);
					}

				?>
			</li>
		<?php endforeach; ?>

		<li>
			<div class="buttons">
				<?php echo form_submit('filter-'.$stream->stream_slug, lang('buttons:filter'), 'class="button"'); ?>
				<?php echo anchor(current_url(), lang('buttons:clear'), 'class="button"'); ?>
			</div>
		</li>
	</ul>
	<?php echo form_close(); ?>
</fieldset>
<?php endif; ?>

<div class="hidden advanced-filters-data">


	<!-- Blank Row (for adding) -->
	<table class="blank-row">
		
		<tr>
			
			<td width="217">
				
				<select class="skip no-margin streams-field-filter-on">
					<option value="-----">-----</option>
					<?php foreach ($stream_fields as $slug => $stream_field): ?>
						<option value="<?php echo $slug; ?>"><?php echo lang_label($stream_field->field_name); ?></option>
					<?php endforeach; ?>
				</select>

			</td>

			<td width="217" class="streams-field-filter-conditions">
				<select class="skip no-margin" disabled="disabled">
					<option value="-----">-----</option>
				</select>
			</td>

			<td class="vertical-align-middle streams-field-filter-input">Select a field...</td>

			<td class="text-center vertical-align-middle">
				<a href="#" class="color-red remove-advanced-filter">
					<i class="icon-minus-sign"></i>
				</a>
			</td>

		</tr>

	</table>
	<!-- /Blank Row (for adding) -->


	<!-- Field Data -->
	<?php foreach ($stream_fields as $slug => $stream_field): ?>	
	<?php $stream_field->filter_output = $this->type->filter_output($stream, $stream_field, null); ?>
	<section class="streams-<?php echo $slug; ?>-filter-data">

		<div class="conditions">
			<?php echo form_dropdown('f-'.$stream->stream_slug.'-condition[]', $stream_field->filter_output['conditions'], null, 'class="skip no-margin"'); ?>
		</div>

		<div class="input">
			<?php echo form_hidden('f-'.$stream->stream_slug.'-filter[]', $slug); ?>
			<?php echo $stream_field->filter_output['input']; ?>
		</div>

	</section>
	<?php endforeach; ?>


</div>
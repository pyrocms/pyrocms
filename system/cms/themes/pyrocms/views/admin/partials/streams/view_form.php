<div class="view-form">

	<?php echo form_open_multipart(uri_string(), 'class="streams_view_form"'); ?>


		<!-- Name -->
		<fieldset class="padded no-padding-bottom">

			<h4 class="no-margin padding-bottom">Name</h4>


			<!-- The Value -->
			<?php echo form_input('name', $view->name); ?>

		</fieldset>
		<!-- /Choose Columns -->


		<hr/>


		<!-- Choose Columns -->
		<fieldset class="padding-left padding-right">

			<h4 class="no-margin padding-bottom">Choose Columns</h4>


			<?php foreach ($stream_fields as $slug=>$stream_field): ?>
			<label>
				<input type="checkbox" class="show-column" <?php echo in_array($slug, $view->view_assignments) ? 'checked="checked"' : null; ?> data-column="<?php echo $stream_field->assign_id; ?>">
				<?php echo lang_label($stream_field->field_name); ?>
			</label>
			<?php endforeach; ?>

		</fieldset>
		<!-- /Choose Columns -->


		<hr/>


		<!-- Column Order -->
		<fieldset class="padding-left padding-right">

			<h4 class="no-margin padding-bottom">Column Order</h4>


			<!-- Define their ordering -->
			<div class="well dd column-order">

				<ul class="dd-list">
					
					<?php foreach ($view->view_assignments as $column): ?>
					<li class="dd-item" data-column="<?php echo $column; ?>">
						<div class="dd-handle">
							<?php echo lang_label($stream_fields->$column->field_name); ?>
						</div>
						<input type="hidden" name="column[]" value="<?php echo $stream_fields->{$column}->assign_id; ?>"/>
					</li>
					<?php endforeach; ?>

					<li class="dd-item empty" style="<?php if (! empty($view->view_assignments)) echo 'display: none;' ?>">
						Please choose some columns first.
					</li>
					
				</ul>

			</div>

		</fieldset>
		<!-- /Column Order -->


		<hr/>


		<!-- Order By -->
		<fieldset class="padding-left padding-right">

			<h4 class="no-margin padding-bottom">Order By</h4>

			<?php echo form_dropdown('order', $stream_fields_dropdown, $view->order_by); ?>

			<?php echo form_dropdown('sort', array('ASC' => 'ASC', 'DESC' => 'DESC'), $view->sort); ?>
			
		</fieldset>
		<!-- /Order By -->


		<hr/>


		<!-- Search Fields -->
		<fieldset class="padding-left padding-right">

			<h4 class="no-margin padding-bottom">Search Fields</h4>
		
			<?php echo form_multiselect('search[]', $stream_fields_dropdown, $view->search); ?>

		</fieldset>
		<!-- /Search Fields -->


		<hr/>


		<!-- Advanced Filters -->
		<fieldset class="padding-left padding-right advanced-filters">

			<table class="table table-bordered bg-white">
				<tr class="bg-grayLighter">
					<th colspan="3">Advanced Filters</th>
					<th class="text-center" width="50">
						<a href="#" class="add-advanced-filter">Add <i class="icon-plus-sign color-green"></i></a>
					</th>
				</tr>

				<?php if (! empty($view->view_filters)): ?>
				<?php foreach ($view->view_filters as $k => $view_filter): ?>

					<?php $filter_output = $this->type->filter_output($stream, $stream_fields->{$view_filter->field_slug}, $view_filter->default_value); ?>

					<tr>
		
						<td width="217">
							
							<select class="skip no-margin streams-field-filter-on">
								<option value="-----">-----</option>
								<?php foreach ($stream_fields as $slug => $stream_field): ?>
									<option <?php echo $slug == $view_filter->field_slug ? 'selected="selected"' : null; ?> value="<?php echo $slug; ?>"><?php echo lang_label($stream_field->field_name); ?></option>
								<?php endforeach; ?>
							</select>

						</td>

						<td width="217" class="streams-field-filter-conditions">
							<?php echo form_dropdown('f-'.$stream->stream_slug.'-condition[]', $filter_output['conditions'], $view_filter->condition, 'class="skip no-margin"'); ?>
						</td>

						<td class="vertical-align-middle streams-field-filter-input">
							<?php echo form_hidden('f-'.$stream->stream_slug.'-filter[]', $view_filter->field_slug); ?>
							<?php echo $filter_output['input']; ?>
						</td>

						<td class="text-center vertical-align-middle">
							<a href="#" class="color-red remove-advanced-filter">
								<i class="icon-minus-sign"></i>
							</a>
						</td>

					</tr>

				<?php endforeach; ?>
				<?php endif; ?>
			</table>

		</fieldset>
		<!-- /Advanced Filters -->


		<hr/>


		<?php if ($method == 'edit'){ ?><input type="hidden" value="<?php echo $view->id;?>" name="row_edit_id" /><?php } ?>

		<!-- Save / Actions -->
		<div class="btn-group padding-left padding-right">
			<button type="submit" name="btnAction" value="save" class="btn"><span><?php echo lang('buttons:save'); ?></span></button>	
			<a href="<?php echo site_url(isset($return) ? $return : 'admin/'.$this->module_details['slug']); ?>" class="btn"><?php echo lang('buttons:cancel'); ?></a>
		</div>

	<?php echo form_close();?>


	<?php $this->load->view('admin/partials/streams/advanced_filters_data'); ?>

</div>
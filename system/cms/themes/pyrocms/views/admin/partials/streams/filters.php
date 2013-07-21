<?php if ( $filters != null ): ?>	
<section class="filters-wrapper">

	
	<!-- Everything is called from this magical form -->
	<form id="advanced-<?php echo $stream->stream_slug; ?>-filters" class="advanced-filters padded no-margin bg-grayLigh border-bottom border-color-grayLighter" method="get">

		
		<?php if ($this->input->get($stream->stream_slug.'-view')): ?>
			<?php echo form_hidden($stream->stream_slug.'-view', $this->input->get($stream->stream_slug.'-view')); ?>
		<?php endif; ?>

		
		<div class="row-fluid">
			
			<div class="span8">

				<!-- Search -->
				<?php if (isset($filters['search']) and ! empty($filters['search'])): ?>

				<?php 

					// Build our placeholder real quick
					$placeholder = array();
					foreach ($filters['search'] as $field_slug)
					{
						$placeholder[] = lang_label($stream_fields->$field_slug->field_name);
					}
				?>

					<input type="hidden" name="search-<?php echo $stream->stream_slug; ?>" value="<?php echo implode('|', $filters['search']); ?>"/>

					<label class="display-inline margin-right">
						Search:
						<input type="text" name="search-<?php echo $stream->stream_slug; ?>-term" placeholder="<?php echo implode(', ', $placeholder); ?>" value="<?php echo $this->input->get('search-'.$stream->stream_slug.'-term'); ?>" class="search" style="width: 95%;"/>
					</label>

				<?php endif; ?>

			</div>

			<div class="span4 text-right">

				<div class="pull-left">
					<br/>
					<button class="btn btn-primary btn-small">Search</button>
					<a href="<?php echo site_url(uri_string()); ?>" class="btn btn-small clear">Clear</a>
				</div>

				<?php if (! isset($filters['advanced_filters']) or $filters['advanced_filters'] !== false): ?>
				<br/>
				<a href="#" data-toggle="toggle" data-target=".advanced-<?php echo $stream->stream_slug; ?>-filters" data-state="<?php echo $this->input->get('f-'.$stream->stream_slug.'-filter') ? 'visible' : 'hidden'; ?>" data-collapsed-chevron="left">
					Advanced <small><i class="icon-chevron-down"></i></small>
				</a>
				<?php endif; ?>
			</div>
			
		</div>
		<!-- /Defined Filters -->


		<!-- Advanced Filters -->
		<?php if (! isset($filters['advanced_filters']) or $filters['advanced_filters'] !== false): ?>
		<section class="margin-top advanced-filters advanced-<?php echo $stream->stream_slug; ?>-filters" data-stream-slug="<?php echo $stream->stream_slug; ?>">

			
			<div class="row-fluid">
			<div class="span12 text-right">
					

					<table class="table table-bordered bg-white">
						<tr class="bg-grayLighter">
							<th colspan="3">Advanced Filters</th>
							<th class="text-center" width="50">
								<a href="#" class="add-advanced-filter">Add <i class="icon-plus-sign color-green"></i></a>
							</th>
						</tr>

						<?php if ($this->input->get('f-'.$stream->stream_slug.'-filter')): ?>
						<?php $query_string_variables = $this->input->get(); ?>
						<?php foreach ($query_string_variables['f-'.$stream->stream_slug.'-filter'] as $k => $filter): ?>

							<?php $filter_output = $this->type->filter_output($stream, $stream_fields->$filter, $query_string_variables['f-'.$stream->stream_slug.'-value'][$k]); ?>

							<tr>
				
								<td width="217">
									
									<select class="skip no-margin streams-field-filter-on">
										<option value="-----">-----</option>
										<?php foreach ($stream_fields as $slug => $stream_field): ?>
											<option <?php echo $slug == $filter ? 'selected="selected"' : null; ?> value="<?php echo $slug; ?>"><?php echo lang_label($stream_field->field_name); ?></option>
										<?php endforeach; ?>
									</select>

								</td>

								<td width="217" class="streams-field-filter-conditions">
									<?php echo form_dropdown('f-'.$stream->stream_slug.'-condition[]', $filter_output['conditions'], $query_string_variables['f-'.$stream->stream_slug.'-condition'][$k], 'class="skip no-margin"'); ?>
								</td>

								<td class="vertical-align-middle streams-field-filter-input">
									<?php echo form_hidden('f-'.$stream->stream_slug.'-filter[]', $filter); ?>
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


			</div>
			</div>

			
			<?php $this->load->view('admin/partials/streams/customize_results'); ?>


		</section>
		<?php endif; ?>
		<!-- /Advanced Filters -->


	</form>


	<!-- We need this -->
	<?php $this->load->view('admin/partials/streams/advanced_filters_data'); ?>


</section>
<?php endif; ?>
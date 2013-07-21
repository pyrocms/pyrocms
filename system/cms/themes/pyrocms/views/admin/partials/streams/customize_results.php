<!-- Controls -->
<div class="row-fluid">
<div class="span12">

	<section class="btn-group pull-right">
		
		<!-- Open our customization modal -->
		<a href="#customize-<?php echo $stream->stream_slug; ?>-results" data-toggle="modal" class="btn btn-small">
			Customize Results <i class="icon-cogs"></i>
		</a>

	</section>

</div>
</div>
<!-- /Controls -->



<!-- MODAL: Customize Results -->
<div id="customize-<?php echo $stream->stream_slug; ?>-results" class="modal customize-results hide fade" tabindex="-1" role="dialog" data-height="500">

	
	<!-- Our Header -->
	<div class="modal-header">

		<button type="button" class="close" data-dismiss="modal">×</button>
		
		<h3 id="myModalLabel">Customize Results</h3>

	</div>

	
	<!-- Body Content -->
	<div class="modal-body padded" data-stream="<?php echo $stream->stream_slug; ?>">


		<!-- Choose Columns -->
		<div class="content-wrapper">

			<h4 class="no-margin padding-bottom">Choose Columns</h4>


			<?php foreach ($stream_fields as $slug=>$stream_field): ?>
			<label>
				<input type="checkbox" class="show-column" <?php echo (isset($_GET[$stream->stream_slug.'-column']) and in_array($slug, $_GET[$stream->stream_slug.'-column'])) ? 'checked="checked"' : null; ?> data-column="<?php echo $slug; ?>">
				<?php echo lang_label($stream_field->field_name); ?>
			</label>
			<?php endforeach; ?>

		</div>
		<!-- /Choose Columns -->


		<hr/>


		<!-- Column Order -->
		<div class="content-wrapper">

			<h4 class="no-margin padding-bottom">Column Order</h4>


			<!-- Define their ordering -->
			<div class="well dd column-order">

				<ul class="dd-list">
					
					<?php if (isset($_GET[$stream->stream_slug.'-column'])): ?>
					<?php foreach ($columns = $_GET[$stream->stream_slug.'-column'] as $column): ?>
					<li class="dd-item" data-column="<?php echo $column; ?>">
						<div class="dd-handle">
							<?php echo lang_label($stream_fields->$column->field_name); ?>
						</div>
						<input type="hidden" name="<?php echo $stream->stream_slug; ?>-column[]" value="<?php echo $column; ?>"/>
					</li>
					<?php endforeach; ?>
					<?php endif; ?>

					<li class="dd-item empty" style="<?php if ($this->input->get($stream->stream_slug.'-column')) echo 'display: none;' ?>">
						Please choose some columns first.
					</li>
					
				</ul>

			</div>

		</div>
		<!-- /Column Order -->


		<hr/>


		<!-- Order By -->
		<div class="content-wrapper">

			<h4 class="no-margin padding-bottom">Order By</h4>


			<!-- Order By Options -->
			<select name="order-<?php echo $stream->stream_slug; ?>" class="no-margin">
				<?php foreach ($stream_fields as $slug => $stream_field): ?>
				<option <?php echo ($this->input->get('order-'.$stream->stream_slug) == $slug ? 'selected="selected"' : null); ?> value="<?php echo $slug; ?>"><?php echo lang_label($stream_field->field_name); ?></option>
				<?php endforeach; ?>
			</select>

			<select name="sort-<?php echo $stream->stream_slug; ?>" class="no-margin">
				<option <?php echo ($this->input->get('sort-'.$stream->stream_slug) ? 'selected="selected"' : null); ?> value="ASC">ASC</option>
				<option <?php echo ($this->input->get('sort-'.$stream->stream_slug) ? 'selected="selected"' : null); ?> value="DESC">DESC</option>
			</select>

		</div>
		<!-- /Order By -->


	</div>
	<!-- /Body Content -->
	

	<!-- Modal Footer -->
	<div class="modal-footer">
		<button class="btn btn-primary" data-dismiss="modal">Ok</button>
	</div>

</div>
<!-- /MODAL: Customize Results -->
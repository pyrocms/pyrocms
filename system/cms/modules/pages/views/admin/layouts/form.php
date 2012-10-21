<section class="title">
	<?php if ($this->method == 'create'): ?>
	<h4><?php echo lang('page_layouts.create_title');?></h4>
	<?php else: ?>
	<h4><?php echo sprintf(lang('page_layouts.edit_title'), $page_layout->title);?></h4>
	<?php endif; ?>
</section>

<section class="item">
	
<?php echo form_open(); ?>

	<div class="tabs">
	
		<ul class="tab-menu">
			<li><a href="#page-layout-html"><span><?php echo lang('page_layouts.html_label');?></span></a></li>
			<li><a href="#page-layout-variables"><span><?php echo lang('page_layouts.variables_label');?></span></a></li>
			<li><a href="#page-layout-css"><span><?php echo lang('page_layouts.css_label');?></span></a></li>
			<li><a href="#page-layout-script"><span><?php echo lang('pages:js_label');?></span></a></li>
		</ul>
		
		<div class="form_inputs" id="page-layout-html">
		
			<fieldset>
				
				<ul>
					<li class="even">
						<label for="title"><?php echo lang('global:title');?> <span>*</span></label>
						<div class="input"><?php echo form_input('title', $page_layout->title, 'maxlength="60"'); ?></div>
					</li>
					
					<li>
						<label for="theme_layout"><?php echo lang('page_layouts:theme_layout_label');?></label>
						<div class="input"><?php echo form_dropdown('theme_layout', $theme_layouts, $page_layout->theme_layout ? $page_layout->theme_layout : 'default'); ?></div>
					</li>
			
					<li class="even">
						<label for="html_editor"><?php echo lang('page_layouts.layout'); ?></label>
						<?php echo form_textarea(array('id'=>'html_editor', 'name'=>'body', 'value' => ($page_layout->body == '' ? '<h2>{{ page:title }}</h2>'.PHP_EOL.'{{ page:body }}' : $page_layout->body), 'rows' => 50)); ?>
					</li>
				</ul>
				
			</fieldset>
		
		</div>

		<!-- Variables tab -->
		<div class="form_inputs" id="page-layout-variables">
			<fieldset>
				<table>
					<thead>
						<tr>
							<th><?php echo lang('page_layouts.name'); ?></th>
							<th><?php echo lang('page_layouts.description'); ?></th>
							<th><?php echo lang('page_layouts.type'); ?></th>
							<th><?php echo lang('page_layouts.options'); ?> *</th>
							<th><?php echo lang('page_layouts.delete'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($page_variables as $page_variable): ?>
							<tr>
								<td>
									<?php echo form_hidden('edit_variable['.$page_variable->id.'][id]', $page_variable->id); ?>
									<?php echo form_hidden('edit_variable['.$page_variable->id.'][layout_id]', $page_layout->id); ?>
									<?php echo form_input('edit_variable['.$page_variable->id.'][name]', $page_variable->name); ?>
								</td>
								<td><?php echo form_input('edit_variable['.$page_variable->id.'][description]', $page_variable->description); ?></td>
								<td><?php echo form_dropdown('edit_variable['.$page_variable->id.'][type]', array('image' => lang('page_layouts.option_image'), 'text' => lang('page_layouts.option_text'), 'dropdown' => lang('page_layouts.option_dropdown')), $page_variable->type); ?></td>
								<td><?php echo form_input('edit_variable['.$page_variable->id.'][options]', $page_variable->options) ?></td>
								<td><input type="checkbox" name="delete_variables[]" value="<?php echo $page_variable->id; ?>" /></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
				<input id="add_page_layout_variable" type="button" value="Add page variable" data-layout-id="<?php echo $page_layout->id; ?>">
				<br /><br />
				<small>* <?php echo lang('page_layouts.options_explaination'); ?></small>
			</fieldset>
		</div>
		
		<!-- Design tab -->
		<div class="form_inputs" id="page-layout-css">
			
			<fieldset>
		
			<ul>
				<li>
					<label for="css">CSS</label><br />
					<?php echo form_textarea('css', $page_layout->css, 'class="css_editor" id="css"'); ?>
				</li>
			</ul>
			
			</fieldset>
			
		</div>
		
		<!-- Script tab -->
		<div class="form_inputs" id="page-layout-script">

			<fieldset>

			<ul>
				<li>
					<label for="js">JavaScript</label><br />
					<?php echo form_textarea('js', $page_layout->js, 'class="js_editor" id="js"'); ?>
				</li>
			</ul>

			</fieldset>

		</div>
		
	</div>

	<div class="buttons float-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel') )); ?>
	</div>

<?php echo form_close(); ?>
</section>
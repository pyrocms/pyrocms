<div class="p">

	<!-- .panel -->
	<section class="panel panel-default">

		<div class="panel-heading">
			<h3 class="panel-title">
				<?php if ($this->method == 'create'): ?>
					<?php echo lang('page_types:create_title');?>
				<?php else: ?>
					<?php echo sprintf(lang('page_types:edit_title'), $page_type->title);?>
				<?php endif; ?>
			</h3>
		</div>

		<!-- .panel-content -->
		<div class="panel-content">


			<?php echo form_open(); ?>

				<div class="tabs">

					<ul class="nav nav-tabs">
						<li class="active"><a href="#page-layout-basic" data-toggle="tab"><span><?php echo lang('page_types:basic_info');?></span></a></li>
						<li><a href="#page-layout-layout" data-toggle="tab"><span><?php echo lang('page_types:layout');?></span></a></li>
						<li><a href="#page-layout-meta" data-toggle="tab"><span><?php echo lang('pages:meta_label');?></span></a></li>
						<li><a href="#page-layout-css" data-toggle="tab"><span><?php echo lang('page_types:css_label');?></span></a></li>
						<li><a href="#page-layout-script" data-toggle="tab"><span><?php echo lang('pages:script_label');?></span></a></li>
					</ul>

					<!-- .tab-content -->
					<div class="tab-content panel-body">

						<div class="tab-pane active" id="page-layout-basic">

							<div class="form-group">
							<div class="row">
								
								<label class="col-lg-2" for="title">
									<?php echo lang('global:title');?> <span>*</span>
								</label>
								
								<div class="col-lg-10">
									<?php echo form_input('title', $page_type->title, 'id="text" maxlength="60" class="form-control"'); ?>
								</div>

							</div>
							</div>
								

							<div class="form-group">
							<div class="row">
								
								<label class="col-lg-2" for="title">
									<?php echo lang('global:slug');?> <span>*</span>
								</label>

								<div class="col-lg-10">
									<?php if ($this->method == 'create'): ?>
									<?php echo form_input('slug', $page_type->slug, 'id="slug" class="form-control" maxlength="60"'); ?>
									<?php else: ?>
									<em><?php echo $page_type->slug; ?></em>
									<?php endif; ?>
								</div>
								
							</div>
							</div>


	                        <div class="form-group">
							<div class="row">
								
								<label class="col-lg-2" for="description">
									<?php echo lang('global:description');?>
								</label>
								
								<div class="col-lg-10">
									<?php echo form_input('description', $page_type->description, 'id="description" class="form-control"'); ?>
								</div>
	                            
	                        </div>
	                        </div>

							
							<?php if ($this->method == 'edit'): ?>
								<?php echo form_hidden('old_slug', $page_type->slug); ?>
							<?php endif; ?>

							
							<div class="form-group">
							<div class="row">
								
								<label class="col-lg-2" for="stream_slug">
									<?php echo lang('page_types:select_stream');?> <span>*</span><?php if ($this->method == 'new'): ?><br><small><?php echo lang('page_types:stream_instructions'); ?></small><?php endif; ?>
								</label>

								<div class="col-lg-10">

									<?php if ($this->method == 'create'): ?>

										<?php echo form_dropdown('stream_id', array('new' => lang('page_types:auto_create_stream')) + $streams_dropdown, isset($page_type->stream_slug) ? $page_type->stream_slug : false); ?>

									<?php else: ?>

										<p><em><?php echo $this->db->limit(1)->select('stream_name')->where('id', $page_type->stream_id)->get(STREAMS_TABLE)->row()->stream_name; ?></em></p>

									<?php endif; ?>
								</div>
							
							</div>
							</div>

							
							<div class="form-group">
							<div class="row">
								
								<label class="col-lg-2" for="theme_layout">
									<?php echo lang('page_types:theme_layout_label');?> <span>*</span>
								</label>
								
								<div class="col-lg-10">
									<?php echo form_dropdown('theme_layout', $theme_layouts, $page_type->theme_layout ? $page_type->theme_layout : 'default'); ?>
								</div>
							
							</div>
							</div>


							<div class="form-group">
							<div class="row">
								
								<label class="col-lg-2" for="save_as_files">
									<?php echo lang('page_types:save_as_files');?><br><small><?php echo lang('page_types:saf_instructions'); ?></small>
								</label>
								
								<div class="col-lg-10">
									<?php echo form_checkbox('save_as_files', 'y', $page_type->save_as_files == 'y' ? true : false, 'id="save_as_files"'); ?>
								</div>
							
							</div>
							</div>


							<div class="form-group">
							<div class="row">
								
								<label class="col-lg-2" for="content_label">
									<?php echo lang('page_types:content_label');?><br><small><?php echo lang('page_types:content_label_instructions'); ?></small>
								</label>
								
								<div class="col-lg-10">
									<?php echo form_input('content_label', $page_type->content_label, 'id="content_label" class="form-control" maxlength="60"'); ?>
								</div>
							
							</div>
							</div>

							
							<div class="form-group">
							<div class="row">
								
								<label class="col-lg-2" for="title_label">
									<?php echo lang('page_types:title_label');?><br><small><?php echo lang('page_types:title_label_instructions'); ?></small>
								</label>

								<div class="col-lg-10">
									<?php echo form_input('title_label', $page_type->title_label, 'id="title_label" class="form-control" maxlength="100"'); ?>
								</div>
							
							</div>
							</div>

						</div>
						<!-- /.tab-pane -->

						
						<!-- .tab-pane -->
						<div class="tab-pane" id="page-layout-layout">

							<div class="form-group">
							<div class="row">
							<div class="col-lg-12">
								
								<label for="html_editor">
									<?php echo lang('page_types:layout'); ?> <span>*</span>
								</label>

								<br/>
								
								<div>
									<?php echo form_textarea(array('id'=>'html_editor', 'name'=>'body', 'value' => ($page_type->body == '' ? '<h2>{{ title }}</h2>' : $page_type->body), 'rows' => 50, 'data-editor' => 'html')); ?>
								</div>
							
							</div>
							</div>
							</div>

						</div>
						<!-- /.tab-pane -->

						
						<!-- .tab-pane -->
						<div class="tab-pane" id="page-layout-meta">

							<div class="form-group">
							<div class="row">
								
								<label class="col-lg-2" for="meta_title">
									<?php echo lang('pages:meta_title_label');?>
								</label>
								
								<div class="col-lg-10">
									<input type="text" id="meta_title" class="form-control" name="meta_title" maxlength="255" value="<?php echo $page_type->meta_title; ?>" />
								</div>
								
							</div>
							</div>

								
							<div class="form-group">
							<div class="row">
								
								<label class="col-lg-2" for="meta_keywords">
									<?php echo lang('pages:meta_keywords_label');?>
								</label>
								
								<div class="col-lg-10">
									<input type="text" id="meta_keywords" class="tags" name="meta_keywords" maxlength="255" value="<?php echo $page_type->meta_keywords; ?>" />
								</div>
							
							</div>
							</div>

							
							<div class="form-group">
							<div class="row">

								<label class="col-lg-2" for="meta_description">
									<?php echo lang('pages:meta_desc_label');?>
								</label>

								<div class="col-lg-10">
									<?php echo form_textarea(array('name' => 'meta_description', 'value' => $page_type->meta_description, 'rows' => 5,  'class' => 'form-control')); ?>
								</div>
							
							</div>
							</div>

						</div>
						<!-- /.tab-pane -->


						<!-- .tab-pane -->
						<div class="tab-pane" id="page-layout-css">

							<div class="form-group">
							<div class="row">
							<div class="col-lg-12">

								<label for="css">
									<?php echo lang('page_types:css_label'); ?>
								</label>

								<br/>

								<div>
									<?php echo form_textarea('css', $page_type->css, 'data-editor="css" id="css"'); ?>
								</div>

							</div>
							</div>
							</div>

						</div>
						<!-- /.tab-pane -->


						<!-- .tab-pane -->
						<div class="tab-pane" id="page-layout-script">

							<div class="form-group">
							<div class="row">
							<div class="col-lg-12">

								<label for="js">
									JavaScript
								</label>

								<br/>

								<div>
									<?php echo form_textarea('js', $page_type->js, 'data-editor="js" id="js"'); ?>
								</div>

							</div>
							</div>
							</div>

						</div>
						<!-- /.tab-pane -->

					</div>
					<!-- /.tab-content -->

				</div>

				<div class="panel-footer">
					<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel') )); ?>
				</div>

			<?php echo form_close(); ?>

		
		</div>
		<!-- /.panel-content -->

	</section>
	<!-- /.panel -->

</div>
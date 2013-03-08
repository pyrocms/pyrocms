<section class="title">
	<?php if ($this->method == 'create'): ?>
	<h4><?php echo lang('page_types:create_title');?></h4>
	<?php else: ?>
	<h4><?php echo sprintf(lang('page_types:edit_title'), $page_type->title);?></h4>
	<?php endif; ?>
</section>

<section class="item">
	<div class="content">
	
		<?php echo form_open(); ?>
		
			<div class="tabs">
			
				<ul class="tab-menu">
					<li><a href="#page-layout-basic"><span><?php echo lang('page_types:basic_info');?></span></a></li>
					<li><a href="#page-layout-layout"><span><?php echo lang('page_types:layout');?></span></a></li>
					<li><a href="#page-layout-meta"><span><?php echo lang('pages:meta_label');?></span></a></li>
					<li><a href="#page-layout-css"><span><?php echo lang('page_types:css_label');?></span></a></li>
					<li><a href="#page-layout-script"><span><?php echo lang('pages:script_label');?></span></a></li>
				</ul>
				
				<div class="form_inputs" id="page-layout-basic">
				
					<fieldset>
						
						<ul>
		
							<li>
								<label for="title"><?php echo lang('global:title');?> <span>*</span></label>
								<div class="input"><?php echo form_input('title', $page_type->title, 'id="text" maxlength="60"'); ?></div>
							</li>
		
							<li>
								<label for="title"><?php echo lang('global:slug');?> <span>*</span></label>
								<div class="input">
								<?php if ($this->method == 'create'): ?>
								<?php echo form_input('slug', $page_type->slug, 'id="slug" maxlength="60"'); ?>
								<?php else: ?>
								<em><?php echo $page_type->slug; ?></em>
								<?php endif; ?>
								</div>
							</li>

                            <li>
                                <label for="description"><?php echo lang('global:description');?></label>
                                <div class="input"><?php echo form_input('description', $page_type->description, 'id="description"'); ?></div>
                            </li>
		
							<?php if ($this->method == 'edit'): ?>
								<?php echo form_hidden('old_slug', $page_type->slug); ?>
							<?php endif; ?>
		
							<li>
								<label for="stream_slug"><?php echo lang('page_types:select_stream');?> <span>*</span><?php if ($this->method == 'new'): ?><br><small><?php echo lang('page_types:stream_instructions'); ?></small><?php endif; ?></label>
		
								<div class="input">
		
									<?php if ($this->method == 'create'): ?>
									
										<?php echo form_dropdown('stream_id', array('new' => lang('page_types:auto_create_stream')) + $streams_dropdown, isset($page_type->stream_slug) ? $page_type->stream_slug : false); ?>
		
									<?php else: ?>
								
										<p><em><?php echo $this->db->limit(1)->select('stream_name')->where('id', $page_type->stream_id)->get(STREAMS_TABLE)->row()->stream_name; ?></em></p>
		
									<?php endif; ?>
								</div>
							</li>
							
							<li>
								<label for="theme_layout"><?php echo lang('page_types:theme_layout_label');?> <span>*</span></label>
								<div class="input"><?php echo form_dropdown('theme_layout', $theme_layouts, $page_type->theme_layout ? $page_type->theme_layout : 'default'); ?></div>
							</li>
		
							<li>
								<label for="save_as_files"><?php echo lang('page_types:save_as_files');?><br><small><?php echo lang('page_types:saf_instructions'); ?></small></label>
								<div class="input"><?php echo form_checkbox('save_as_files', 'y', $page_type->save_as_files == 'y' ? true : false, 'id="save_as_files"'); ?></div>
							</li>
			
							<li>
								<label for="content_label"><?php echo lang('page_types:content_label');?><br><small><?php echo lang('page_types:content_label_instructions'); ?></small></label>
								<div class="input"><?php echo form_input('content_label', $page_type->content_label, 'id="content_label" maxlength="60"'); ?></div>
							</li>		
			
							<li>
								<label for="title_label"><?php echo lang('page_types:title_label');?><br><small><?php echo lang('page_types:title_label_instructions'); ?></small></label>
								<div class="input"><?php echo form_input('title_label', $page_type->title_label, 'id="title_label" maxlength="100"'); ?></div>
							</li>
								
						</ul>
						
					</fieldset>
				
				</div>
		
				<div class="form_inputs" id="page-layout-layout">
				
					<fieldset>
						
						<ul>
							<li>
								<label for="html_editor"><?php echo lang('page_types:layout'); ?> <span>*</span></label>
								<?php echo form_textarea(array('id'=>'html_editor', 'name'=>'body', 'value' => ($page_type->body == '' ? '<h2>{{ title }}</h2>' : $page_type->body), 'rows' => 50)); ?>
							</li>
						</ul>
		
					</fieldset>
		
				</div>
		
				<!-- Meta data tab -->
				<div class="form_inputs" id="page-layout-meta">
				
					<fieldset>
				
					<ul>
						<li>
							<label for="meta_title"><?php echo lang('pages:meta_title_label');?></label>
							<div class="input"><input type="text" id="meta_title" name="meta_title" maxlength="255" value="<?php echo $page_type->meta_title; ?>" /></div>
						</li>
										
						<li>
							<label for="meta_keywords"><?php echo lang('pages:meta_keywords_label');?></label>
							<div class="input"><input type="text" id="meta_keywords" name="meta_keywords" maxlength="255" value="<?php echo $page_type->meta_keywords; ?>" /></div>
						</li>
						
						<li>
							<label for="meta_description"><?php echo lang('pages:meta_desc_label');?></label>
							<?php echo form_textarea(array('name' => 'meta_description', 'value' => $page_type->meta_description, 'rows' => 5)); ?>
						</li>
					</ul>
					
					</fieldset>
		
				</div>
		
				
				<!-- Design tab -->
				<div class="form_inputs" id="page-layout-css">
					
					<fieldset>
				
					<ul>
						<li>
							<label for="css"><?php echo lang('page_types:css_label'); ?></label><br />
							<?php echo form_textarea('css', $page_type->css, 'class="css_editor" id="css"'); ?>
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
							<?php echo form_textarea('js', $page_type->js, 'class="js_editor" id="js"'); ?>
						</li>
					</ul>
		
					</fieldset>
		
				</div>
				
			</div>
		
			<div class="buttons float-right padding-top">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel') )); ?>
			</div>
		
		<?php echo form_close(); ?>
	</div>
</section>
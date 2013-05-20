<section class="padded">
<div class="container-fluid">


	<section class="box">

		<section class="box-header">
			<?php if ($this->method == 'create'): ?>
				<span class="title"><?php echo lang('pages:create_title') ?></span>
			<?php else: ?>
				<span class="title"><?php echo sprintf(lang('pages:edit_title'), $page->title) ?></span>
			<?php endif ?>
		</section>

		
		<?php $parent = ($parent_id) ? '&parent='.$parent_id : null ?>
	
		<?php echo form_open_multipart(uri_string().'?page_type='.$this->input->get('page_type').$parent, 'id="page-form" data-mode="'.$this->method.'"') ?>
		<?php echo form_hidden('parent_id', empty($page->parent_id) ? 0 : $page->parent_id) ?>
			
		<ul class="nav nav-tabs padded no-padding-bottom grayLightest-bg">
			<li class="active"><a href="#page-details" data-toggle="tab"><span><?php echo lang('pages:details_label') ?></span></a></li>
			<?php if ($stream_fields): ?><li><a href="#page-content" data-toggle="tab"><span><?php if ($page_type->content_label): echo lang_label($page_type->content_label); else: echo lang('pages:content_label'); endif ?></span></a></li><?php endif ?>
			<li><a href="#page-meta" data-toggle="tab"><span><?php echo lang('pages:meta_label') ?></span></a></li>
			<li><a href="#page-design" data-toggle="tab"><span><?php echo lang('pages:css_label') ?></span></a></li>
			<li><a href="#page-script" data-toggle="tab"><span><?php echo lang('pages:script_label') ?></span></a></li>
			<li><a href="#page-options" data-toggle="tab"><span><?php echo lang('pages:options_label') ?></span></a></li>
		</ul>


		<!-- .tab-content -->
		<div class="tab-content">
	
			<div class="tab-pane active" id="page-details">
				<fieldset>
					<ul>
						
						<li class="row-fluid input-row">
							<label class="span3" for="title"><?php if ($page_type->title_label): echo lang_label($page_type->title_label); else: echo lang('global:title'); endif ?> <span>*</span></label>
							<div class="input span9"><?php echo form_input('title', $page->title, 'id="title" maxlength="60"') ?></div>
						</li>
						
						<li class="row-fluid input-row">
							<label class="span3" for="slug"><?php echo lang('global:slug') ?>  <span>*</span></label>
							
							<div class="input span9">
							<?php if ( ! empty($page->parent_id)): ?>
								<?php echo site_url($parent_page->uri) ?>/
							<?php else: ?>
								<?php echo site_url() . (config_item('index_page') ? '/' : '') ?>
							<?php endif ?>
		
							<?php if ($this->method == 'edit'): ?>
								<?php echo form_hidden('old_slug', $page->slug) ?>
							<?php endif ?>
		
							<?php if (in_array($page->slug, array('home', '404'))): ?>
								<?php echo form_hidden('slug', $page->slug) ?>
								<?php echo form_input('', $page->slug, 'id="slug" size="20" disabled="disabled" class="inline"') ?>
							<?php else: ?>
								<?php echo form_input('slug', $page->slug, 'id="slug" size="20" class="inline '.($this->method == 'edit' ? ' disabled' : '').'"') ?>
							<?php endif ?>
		
							<?php echo config_item('url_suffix') ?>
							
							</div>
						</li>
						
						<li class="row-fluid input-row">
							<label class="span3" for="category_id"><?php echo lang('pages:status_label') ?></label>
							<div class="input span9"><?php echo form_dropdown('status', array('draft'=>lang('pages:draft_label'), 'live'=>lang('pages:live_label')), $page->status, 'id="category_id"') ?></div>
						</li>
						
						<?php if ($this->method == 'create'): ?>
						<li class="row-fluid input-row">
							<label class="span3" for="navigation_group_id"><?php echo lang('pages:navigation_label') ?></label>
							<div class="input span9"><?php echo form_multiselect('navigation_group_id[]', array(lang('global:select-none')) + $navigation_groups, $page->navigation_group_id) ?></div>
						</li>
						<?php endif ?>
					</ul>
				</fieldset>
			</div>
	
			<?php if ($stream_fields): ?>
			
			<!-- Content tab -->
			<div class="tab-pane" id="page-content">
		
				<fieldset>
	
				<ul>
					
					<?php foreach ($stream_fields as $field) echo $this->load->view('admin/partials/streams/form_single_display', array('field' => $field), true) ?>
					
				</ul>
	
				</fieldset>
			
			</div>
	
			<?php endif ?>
	
			<!-- Meta data tab -->
			<div class="tab-pane" id="page-meta">
			
				<fieldset>
			
				<ul>
					<li class="row-fluid input-row">
						<label class="span3" for="meta_title"><?php echo lang('pages:meta_title_label') ?></label>
						<div class="input span9"><input type="text" id="meta_title" name="meta_title" maxlength="255" value="<?php echo $page->meta_title ?>" /></div>
					</li>
									
					<?php if ( ! module_enabled('keywords')): ?>
						<?php echo form_hidden('keywords'); ?>
					<?php else: ?>
						<li class="row-fluid input-row">
							<label class="span3" for="meta_keywords"><?php echo lang('pages:meta_keywords_label') ?></label>
							<div class="input span9"><input type="text" id="meta_keywords" name="meta_keywords" maxlength="255" value="<?php echo $page->meta_keywords ?>" /></div>
						</li>
					<?php endif; ?>
						<li class="row-fluid input-row">
							<label class="span3" for="meta_robots_no_index"><?php echo lang('pages:meta_robots_no_index_label') ?></label>
							<div class="input span9"><?php echo form_checkbox('meta_robots_no_index', true, $page->meta_robots_no_index == true, 'id="meta_robots_no_index"') ?></div>
						</li>

						<li class="row-fluid input-row">
							<label class="span3" for="meta_robots_no_follow"><?php echo lang('pages:meta_robots_no_follow_label') ?></label>
							<div class="input span9"><?php echo form_checkbox('meta_robots_no_follow', true, $page->meta_robots_no_follow == true, 'id="meta_robots_no_follow"') ?></div>
						</li>
					<li class="row-fluid input-row">
						<label class="span3" for="meta_description"><?php echo lang('pages:meta_desc_label') ?></label>
						<div class="input span9">
							<?php echo form_textarea(array('name' => 'meta_description', 'value' => $page->meta_description, 'rows' => 5)) ?>
						</div>
					</li>
				</ul>
				
				</fieldset>
	
			</div>
	
			<!-- Design tab -->
			<div class="tab-pane" id="page-design">
	
				<fieldset>
				
				<ul>
					<li class="row-fluid input-row">
						<label for="css"><?php echo lang('pages:css_label') ?></label><br />
						<div>
							<?php echo form_textarea('css', $page->css, 'class="css_editor"') ?>
						</div>
					</li>
				</ul>
				
				</fieldset>
				
			</div>
	
			<!-- Script tab -->
			<div class="tab-pane" id="page-script">
	
				<fieldset>
	
				<ul>
					<li class="row-fluid input-row">
						<label class="span3" for="js"><?php echo lang('pages:js_label') ?></label><br />
						<div class="input wysiwyg">
							<?php echo form_textarea('js', $page->js, 'class="js_editor"') ?>
						</div>
					</li>
				</ul>
	
				</fieldset>
	
			</div>
	
			<!-- Options tab -->
			<div class="tab-pane" id="page-options">
	
				<fieldset>
	
				<ul>
					<li class="row-fluid input-row">
						<label class="span3" for="restricted_to[]"><?php echo lang('pages:access_label') ?></label>
						<div class="input span9"><?php echo form_multiselect('restricted_to[]', array(0 => lang('global:select-any')) + $group_options, $page->restricted_to, 'size="'.(($count = count($group_options)) > 1 ? $count : 2).'"') ?></div>
					</li>
									
					<?php if ( ! module_enabled('comments')): ?>
						<?php echo form_hidden('comments_enabled'); ?>
					<?php else: ?>
						<li class="row-fluid input-row">
							<label class="span3" for="comments_enabled"><?php echo lang('pages:comments_enabled_label') ?></label>
							<div class="input span9"><?php echo form_checkbox('comments_enabled', true, $page->comments_enabled == true, 'id="comments_enabled"') ?></div>
						</li>
					<?php endif; ?>
									
					<li class="row-fluid input-row">
						<label class="span3" for="rss_enabled"><?php echo lang('pages:rss_enabled_label') ?></label>
						<div class="input span9"><?php echo form_checkbox('rss_enabled', true, $page->rss_enabled == true, 'id="rss_enabled"') ?></div>
					</li>
									
					<li class="row-fluid input-row">
						<label class="span3" for="is_home"><?php echo lang('pages:is_home_label') ?></label>
						<div class="input span9"><?php echo form_checkbox('is_home', true, $page->is_home == true, 'id="is_home"') ?></div>
					</li>
	
					<li class="row-fluid input-row">
						<label class="span3" for="strict_uri"><?php echo lang('pages:strict_uri_label') ?></label>
						<div class="input span9"><?php echo form_checkbox('strict_uri', 1, $page->strict_uri == true, 'id="strict_uri"') ?></div>
					</li>
				</ul>
	
				</fieldset>
	
			</div>
			<!-- /.tab-content -->

			<input type="hidden" name="row_edit_id" value="<?php if ($this->method != 'create'): echo $page->entry_id; endif; ?>" />
		
			<div class="btn-group padded">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel') )) ?>
			</div>
		
			<?php echo form_close() ?>

		</div>

	</section>


</div>
</section>
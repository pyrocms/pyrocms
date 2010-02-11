<div class="box">

	<?php if($method == 'create'): ?>
		<h3><?php echo lang('page_create_title');?></h3>
	<?php else: ?>
		<h3><?php echo sprintf(lang('page_edit_title'), $page->title);?></h3>
	<?php endif; ?>
	
	<div class="box-container">	
	
		<?php echo form_open($this->uri->uri_string(), 'class="crud"'); ?>
		<?php echo form_hidden('parent_id', @$page->parent_id); ?>

		<div class="tabs">
		
			<ul class="tab-menu">
				<li><a href="#page-content"><span><?php echo lang('page_content_label');?></span></a></li>
				<li><a href="#page-design"><span><?php echo lang('page_design_label');?></span></a></li>
				<li><a href="#page-meta"><span><?php echo lang('page_meta_label');?></span></a></li>
			</ul>
			
			<div id="page-content">
			
				<ol>

					<li>
						<label for="title"><?php echo lang('page_title_label');?></label>
						<?php echo form_input('title', $page->title, 'maxlength="60"'); ?>
						<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
					</li>
					
					<li class="even">
						<label for="slug"><?php echo lang('page_slug_label');?></label>
						
						<?php if(!empty($page->parent_id)): ?>
							<?php echo site_url().$parent_page->path; ?>/
						<?php else: ?>
							<?php echo site_url(); ?>
						<?php endif; ?>
						
						<?php if($this->uri->segment(3,'') == 'edit'): ?>
							<?php echo form_hidden('old_slug', $page->slug); ?>
						<?php endif; ?>
						
						<?php if($page->slug == 'home' || $page->slug == '404'): ?>
							<?php echo form_hidden('slug', $page->slug); ?>
							<?php echo form_input('', $page->slug, 'size="20" class="width-10" disabled="disabled"'); ?>
						<?php else: ?>
							<?php echo form_input('slug', $page->slug, 'size="20" class="width-10"'); ?>
							<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
						<?php endif;?>
						
						<?php echo $this->config->item('url_suffix'); ?>
					</li>
					
					<li>
						<label for="category_id"><?php echo lang('page_status_label');?></label>
						<?php echo form_dropdown('status', array('draft'=>lang('page_draft_label'), 'live'=>lang('page_live_label')), $page->status) ?>	
					</li>
					
					<li class="even">
						<?php echo form_textarea(array('id'=>'body', 'name'=>'body', 'value' => stripslashes($page->body), 'rows' => 50, 'class'=>'wysiwyg-advanced')); ?>
					</li>
				</ol>

			</div>
		
			<!-- Design tab -->
			<div id="page-design">
			
				<ol>
					<li class="even">
						<label for="layout_id"><?php echo lang('page_layout_id_label');?></label>
						<?php echo form_dropdown('layout_id', $page_layouts, $page->layout_id); ?>
					</li>
					
					<li>
						<label for="css"><?php echo lang('page_css_label');?></label>
						<div class="float-right">
							<?php echo form_textarea('css', $page->css, 'id="css_editor"'); ?>
						</div>
					</li>
				</ol>
	
				<br class="clear-both" />
				
			</div>
			
			<!-- Meta data tab -->
			<div id="page-meta">
			
				<ol>
					<li class="even">
						<label for="meta_title"><?php echo lang('page_meta_title_label');?></label>
						<input type="text" id="meta_title" name="meta_title" maxlength="255" value="<?php echo $page->meta_title; ?>" />
					</li>
					<li>
						<label for="meta_keywords"><?php echo lang('page_meta_keywords_label');?></label>
						<input type="text" id="meta_keywords" name="meta_keywords" maxlength="255" value="<?php echo $page->meta_keywords; ?>" />
					</li>
					<li class="even">
						<label for="meta_description"><?php echo lang('page_meta_desc_label');?></label>
						<?php echo form_textarea(array('name' => 'meta_description', 'value' => $page->meta_description, 'rows' => 5)); ?>
					</li>
				</ol>
				
			</div>
			
		</div>

		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>

		<?php echo form_close(); ?>
	</div>
	
</div>

<script type="text/javascript">
	css_editor('css_editor', "39em");
</script>
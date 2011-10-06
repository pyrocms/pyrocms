<section class="title">
	<?php if ($this->method == 'create'): ?>
		<h4><?php echo lang('pages.create_title');?></h4>
	<?php else: ?>
		<h4><?php echo sprintf(lang('pages.edit_title'), $page->title);?></h4>
	<?php endif; ?>
</section>

<section class="item">

	<?php echo form_open(uri_string(), 'id="page-form" class="crud"'); ?>
	<?php echo form_hidden('parent_id', (@$page->parent_id == '')? 0 : $page->parent_id); ?>

	<div class="tabs">

		<ul class="tab-menu">
			<li><a href="#page-content"><span><?php echo lang('pages.content_label');?></span></a></li>
			<li><a href="#page-meta"><span><?php echo lang('pages.meta_label');?></span></a></li>
			<li><a href="#page-design"><span><?php echo lang('pages.design_label');?></span></a></li>
			<li><a href="#page-script"><span><?php echo lang('pages.script_label');?></span></a></li>
			<li><a href="#page-options"><span><?php echo lang('pages.options_label');?></span></a></li>
		</ul>
		
		<hr>

		<!-- Content tab -->
		<div style="width:100%" id="page-content">
			<ul>
				<li class="<?php echo alternator('even', ''); ?>">
					<label for="title"><?php echo lang('pages.title_label');?></label><br>
					<?php echo form_input('title', $page->title, 'maxlength="60"'); ?>
					<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
				</li>
				
				<hr>
				
				<li class="<?php echo alternator('even', ''); ?>">
					<label for="slug"><?php echo lang('pages.slug_label');?></label><br>
					<?php if ( ! empty($page->parent_id)): ?>
						<?php echo site_url($parent_page->uri); ?>/
					<?php else: ?>
						<?php echo site_url() . (config_item('index_page') ? '/' : ''); ?>
					<?php endif; ?>

					<?php if ($this->method == 'edit'): ?>
						<?php echo form_hidden('old_slug', $page->slug); ?>
					<?php endif; ?>

					<?php if (in_array($page->slug, array('home', '404'))): ?>
						<?php echo form_hidden('slug', $page->slug); ?>
						<?php echo form_input('', $page->slug, 'size="20" class="width-10" disabled="disabled"'); ?>
					<?php else: ?>
						<?php echo form_input('slug', $page->slug, 'size="20" class="width-10"'); ?>
						<span class="required-icon tooltip"><?php echo lang('required_label'); ?></span>
					<?php endif;?>

					<?php echo config_item('url_suffix'); ?>
				</li>
				
				<hr>
				
				<li class="<?php echo alternator('even', ''); ?>">
					<label for="category_id"><?php echo lang('pages.status_label'); ?></label><br>
					<?php echo form_dropdown('status', array('draft'=>lang('pages.draft_label'), 'live'=>lang('pages.live_label')), $page->status); ?>
				</li>
				
				<hr>
				
				<?php if ($this->method == 'create'): ?>
				<li class="<?php echo alternator('even', ''); ?>">
					<label for="navigation_group_id"><?php echo lang('pages.navigation_label');?></label><br>
					<?php echo form_dropdown('navigation_group_id', array(lang('global:select-none')) + $navigation_groups, $page->navigation_group_id); ?>
				</li>
				<hr>
				<?php endif; ?>
				
				<?php foreach ($page->chunks as $chunk): ?>
					<li class="<?php echo alternator('even', ''); ?> page-chunk">
						<div class="float-left">
						<?php echo form_input('chunk_slug['.$chunk->id.']', $chunk->slug); ?>
						<?php echo form_dropdown('chunk_type['.$chunk->id.']', array(
							'html' => 'html',
							'markdown' => 'markdown',
							'wysiwyg-simple' => 'wysiwyg-simple',
							'wysiwyg-advanced' => 'wysiwyg-advanced',
						), $chunk->type); ?>
						</div>
						<div class="float-right">
							<a href="javascript:void(0)" class="remove-chunk"><?php echo lang('global:remove') ?></a>
						</div>
						<br style="clear:both" />
						<?php echo form_textarea(array('id' => $chunk->slug.'_'.$chunk->id, 'name'=>'chunk_body['.$chunk->id.']', 'value' => $chunk->body, 'rows' => 20, 'class'=> $chunk->type, 'style' => 'width:100%')); ?>
					</li>
					<hr>
				<?php endforeach; ?>
				
				<li class="<?php echo alternator('even', ''); ?>">
					<a class="add-chunk btn orange" href="#"><?php echo lang('pages.add_page_chunk'); ?></a>
				</li>
				<br>
			</ul>
		</div>

		<!-- Meta data tab -->
		<div style="width:100%;" id="page-meta">
			<ul>
				<li class="<?php echo alternator('even', ''); ?>">
					<label for="meta_title"><?php echo lang('pages.meta_title_label');?></label><br>
					<input type="text" id="meta_title" name="meta_title" maxlength="255" value="<?php echo $page->meta_title; ?>" />
				</li>
				
				<hr>
				
				<li class="<?php echo alternator('even', ''); ?>">
					<label for="meta_keywords"><?php echo lang('pages.meta_keywords_label');?></label><br>
					<input type="text" id="meta_keywords" name="meta_keywords" maxlength="255" value="<?php echo $page->meta_keywords; ?>" />
				</li>
				
				<hr>
				
				<li class="<?php echo alternator('even', ''); ?>">
					<label for="meta_description"><?php echo lang('pages.meta_desc_label');?></label><br>
					<?php echo form_textarea(array('name' => 'meta_description', 'value' => $page->meta_description, 'rows' => 5)); ?>
				</li>
				<br>
			</ul>
		</div>

		<!-- Design tab -->
		<div style="width:100%;" id="page-design">
			<ul>
				<li class="<?php echo alternator('even', ''); ?>">
					<label for="layout_id"><?php echo lang('pages.layout_id_label');?></label><br>
					<?php echo form_dropdown('layout_id', $page_layouts, $page->layout_id); ?>
				</li>
				
				<hr>
				
				<li class="<?php echo alternator('even', ''); ?>">
					<label for="css"><?php echo lang('pages.css_label');?></label><br>
					<div>
						<?php echo form_textarea('css', $page->css, 'class="css_editor"'); ?>
					</div>
				</li>
				<br>
			</ul>
			<br class="clear-both" />
		</div>

		<!-- Script tab -->
		<div style="width:100%;" id="page-script">
			<ul>
				<li class="<?php echo alternator('', 'even'); ?>">
					<label for="js"><?php echo lang('pages.js_label'); ?></label>
					<div>
						<?php echo form_textarea('js', $page->js, 'class="js_editor"'); ?>
					</div>
				</li>
			</ul>
			<br class="clear-both" />
		</div>

		<!-- Options tab -->
		<div style="width:100%;" id="page-options">
			<ul>
				<li class="<?php echo alternator('even', ''); ?>">
					<label for="restricted_to[]"><?php echo lang('pages.access_label');?></label><br>
					<?php echo form_multiselect('restricted_to[]', array(0 => lang('global:select-any')) + $group_options, $page->restricted_to, 'size="'.(($count = count($group_options)) > 1 ? $count : 2).'"'); ?>
				</li>
				
				<hr>
				
				<li class="<?php echo alternator('even', ''); ?>">
					<label for="comments_enabled"><?php echo lang('pages.comments_enabled_label');?></label><br>
					<?php echo form_checkbox('comments_enabled', 1, $page->comments_enabled == 1); ?>
				</li>
				
				<hr>
				
				<li class="<?php echo alternator('even', ''); ?>">
					<label for="rss_enabled"><?php echo lang('pages.rss_enabled_label');?></label><br>
					<?php echo form_checkbox('rss_enabled', 1, $page->rss_enabled == 1); ?>
				</li>
				
				<hr>
				
				<li class="<?php echo alternator('even', ''); ?>">
					<label for="is_home"><?php echo lang('pages.is_home_label');?></label>
					<?php echo form_checkbox('is_home', 1, $page->is_home == 1); ?>
				</li>
				<br>
			</ul>
		</div>

	</div>

	<div class="buttons align-right padding-top">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel') )); ?>
	</div>

	<?php echo form_close(); ?>
</section>
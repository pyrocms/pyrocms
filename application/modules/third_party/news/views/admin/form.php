<?php echo form_open($this->uri->uri_string()); ?>
	<div class="fieldset fieldsetBlock active tabs">	
		<div class="header">
			<?php if($method == 'create'): ?>
				<h3><?php echo lang('news_create_title');?></h3>				
			<?php else: ?>
				<h3><?php echo sprintf(lang('news_edit_title'), $article->title);?></h3>
			<?php endif; ?>
		</div>
    
		<div class="tabs">
			
			<ul class="clear-both">
				<li><a href="#fieldset1" title="Write post"><span><?php echo lang('news_content_label');?></span></a></li>
				<li><a href="#fieldset2" title="Post date"><span><?php echo lang('news_options_label');?></span></a></li>
			</ul>
		
			<!-- Content tab -->
			<fieldset id="fieldset1">
				<legend><?php echo lang('news_content_label');?></legend>
			
				<div class="field">
					<label for="title"><?php echo lang('news_title_label');?></label>
					<?php echo form_input('title', $article->title, 'maxlength="100"'); ?>
					<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
				</div>
				
				<div class="field">
					<label for="intro"><?php echo lang('news_intro_label');?></label>
					<?php echo form_textarea(array('id'=>'intro', 'name'=>'intro', 'value' => $article->intro, 'rows' => 5, 'class'=>'wysiwyg-simple')); ?>
				</div>
				
				<div class="field spacer-left">
					<?php echo form_textarea(array('id'=>'body', 'name'=>'body', 'value' =>  stripslashes($article->body), 'rows' => 50, 'class'=>'wysiwyg-advanced')); ?>
				</div>
		
			</fieldset>
		
			<!-- Options tab -->
			<fieldset id="fieldset2">
			
				<legend><?php echo lang('news_options_label');?></legend>
				
				<div class="field">
					<label for="category_id"><?php echo lang('news_category_label');?></label>
					<?php echo form_dropdown('category_id', array(lang('news_no_category_select_label'))+$categories, @$article->category_id) ?> 	
					[ <?php echo anchor('admin/categories/create', lang('news_new_category_label'), 'target="_blank"'); ?> ]
				</div>
				
				<div class="field">
					<label for="category_id"><?php echo lang('news_status_label');?></label>
					<?php echo form_dropdown('status', array('draft'=>lang('news_draft_label'), 'live'=>lang('news_live_label')), $article->status) ?>	
				</div>
				
				<div class="field">
					<label><?php echo lang('news_date_label');?></label>
					<?php echo form_dropdown('created_on_day', $days, !empty($article->created_on_day) ? $article->created_on_day : date('j', isset($article->created_on) ? $article->created_on : now())) ?>
					<?php echo form_dropdown('created_on_month', $months, !empty($article->created_on_month) ? $article->created_on_month : date('n', isset($article->created_on) ? $article->created_on : now())) ?>
					<?php echo form_dropdown('created_on_year', $years, !empty($article->created_on_year) ? $article->created_on_year : date('Y', isset($article->created_on) ? $article->created_on : now())) ?>
					
					<?php echo lang('news_time_label');?>
					<?php echo form_dropdown('created_on_hour', $hours, !empty($article->created_on_hour) ? $article->created_on_hour : date('G', isset($article->created_on) ? $article->created_on : now())) ?>
					<?php echo form_dropdown('created_on_minute', $minutes, !empty($article->created_on_minute) ? $article->created_on_minute : date('i', isset($article->created_on) ? $article->created_on : now())) ?>
				</div>
			
			</fieldset>	
				
		</div>	
	</div>
	<?php $this->load->view('admin/fragments/table_buttons', array('buttons' => array('save', 'cancel') )); ?>
<?php echo form_close(); ?>
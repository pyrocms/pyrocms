<?php if ($this->method == 'create'): ?>
	<h3><?php echo lang('news_create_title');?></h3>
<?php else: ?>
	<h3><?php echo sprintf(lang('news_edit_title'), $article->title);?></h3>
<?php endif; ?>

<?php echo form_open(uri_string(), 'class="crud"'); ?>

	<div class="tabs">

		<ul class="tab-menu">
			<li><a href="#news-content-tab"><span><?php echo lang('news_content_label');?></span></a></li>
			<li><a href="#news-options-tab"><span><?php echo lang('news_options_label');?></span></a></li>
		</ul>

		<div id="news-content-tab">

			<ol>

				<li>
					<label for="title"><?php echo lang('news_title_label');?></label>
					<?php echo form_input('title', htmlspecialchars_decode($article->title), 'maxlength="100"'); ?>
					<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
				</li>

				<li class="even">
					<label for="slug"><?php echo lang('news_slug_label');?></label>
					<?php echo form_input('slug', $article->slug, 'maxlength="100" class="width-20"'); ?>
					<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
				</li>

				<li>
					<label for="status"><?php echo lang('news_status_label');?></label>
					<?php echo form_dropdown('status', array('draft'=>lang('news_draft_label'), 'live'=>lang('news_live_label')), $article->status) ?>
				</li>

				<li class="even">
					<label class="intro" for="intro"><?php echo lang('news_intro_label');?></label>
					<?php echo form_textarea(array('id'=>'intro', 'name'=>'intro', 'value' => $article->intro, 'rows' => 5, 'class'=>'wysiwyg-simple')); ?>
				</li>

				<li>
					<?php echo form_textarea(array('id'=>'body', 'name'=>'body', 'value' =>  stripslashes($article->body), 'rows' => 50, 'class'=>'wysiwyg-advanced')); ?>
				</li>

			</ol>
		</div>

		<!-- Options tab -->
		<div id="news-options-tab">

			<ol>
				<li>
					<label for="category_id"><?php echo lang('news_category_label');?></label>
					<?php echo form_dropdown('category_id', array(lang('news_no_category_select_label'))+$categories, @$article->category_id) ?>
					[ <?php echo anchor('admin/news/categories/create', lang('news_new_category_label'), 'target="_blank"'); ?> ]
				</li>

				<li class="even date-meta">
                
            <label><?php echo lang('news_date_label');?></label>
                      
                      <div style="float:left;">
                                         
                      <?php
                      if(@$article->created_on_day==''&& @$article->date==''){
                        $date = date('d/m/y');
                      }
                      else{
		                $date = isset($article->date) ? $article->date : date('d/m/Y', strtotime($article->created_on_year.'-'.$article->created_on_month.'-'.$article->created_on_day));
                      }
                      
                      echo form_input('date', htmlspecialchars_decode($date), 'maxlength="10" id="datepicker" class="text width-20"'); ?>
                      </div>
  
            <label class="time-meta"><?php echo lang('news_time_label');?></label>
            <?php echo form_dropdown('created_on_hour', $hours, !empty($article->created_on_hour) ? $article->created_on_hour : date('G', isset($article->created_on) ? $article->created_on : now())) ?>
            <?php echo form_dropdown('created_on_minute', $minutes, !empty($article->created_on_minute) ? $article->created_on_minute : date('i', isset($article->created_on) ? $article->created_on : now())) ?>
        </li>
			</ol>

		</div>

	</div>

<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'save_exit', 'cancel') )); ?>

<?php echo form_close(); ?>
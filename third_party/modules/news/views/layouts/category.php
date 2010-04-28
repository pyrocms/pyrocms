<h2>"<?php echo $category->title; ?>"<?php echo lang('news_articles_of_category_suffix');?></h2>
<div class="float-left width-two-thirds">
<?php echo $template['module_body']; ?>
</div>

<div class="float-right width-quater">
	<?php $this->load->view('fragments/rss_box');?>	
	<hr />	
	<?php $this->load->view('fragments/archive_box');?>	
</div>
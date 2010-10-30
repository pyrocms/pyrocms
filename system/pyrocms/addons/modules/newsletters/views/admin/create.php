<h3><?php echo lang('newsletters.add_title'); ?></h3>

<?php echo form_open('admin/newsletters/create', 'class="crud"'); ?>
	
	<ol>
		<li class="even">
			<label for="title"><?php echo lang('letter_title_label');?></label>
			<input type="text" id="title" name="title" maxlength="100" value="<?php echo $newsletter->title; ?>" class="text" />
			<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
		</li>
		
		<li>
			<?php echo form_textarea(array('id'=>'body', 'name'=>'body', 'value' => htmlentities(stripslashes($newsletter->body)), 'rows' => 40, 'class'=>'wysiwyg-advanced')); ?>
		</li>
	</ol>
	<div class="float-right">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
	</div>
<?php echo form_close(); ?>

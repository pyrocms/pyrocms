<?php if ($this->method == 'edit'): ?>
	<section class="title">
    	<h4><?php echo sprintf(lang('keywords:edit_title'), $keyword->name) ?></h4>
	</section>
<?php else: ?>
	<section class="title">
    	<h4><?php echo lang('keywords:add_title') ?></h4>
	</section>
<?php endif ?>

<section class="item">
<div class="content">



<?php echo form_open(uri_string(), 'class="crud"') ?>

<div class="form_inputs">
	
    <ul>
		<li>
			<label for="name"><?php echo lang('keywords:name');?> <span>*</span></label>
			<div class="input"><?php echo form_input('name', $keyword->name);?></div>
		</li>
    </ul>
    
</div>
    
	<div class="buttons">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
	</div>	
	
<?php echo form_close();?>


</div>
</section>

<script type="text/javascript">
	jQuery(function($) {
		$('form input[name="name"]').keyup($.debounce(100, function(){
			$(this).val( this.value.toLowerCase().replace(',', '') );
		}));
	});
</script>
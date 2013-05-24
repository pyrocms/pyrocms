<section class="padded">
<div class="container-fluid">


	<section class="box">

		<?php if ($this->method == 'edit'): ?>
			<section class="box-header">
		    	<span class="title"><?php echo sprintf(lang('keywords:edit_title'), $keyword->name) ?></span>
			</section>
		<?php else: ?>
			<section class="box-header">
		    	<span class="title"><?php echo lang('keywords:add_title') ?></span>
			</section>
		<?php endif ?>


		<?php echo form_open(uri_string(), 'class="crud"') ?>

		<div class="form_inputs">
			
		    <ul>
				<li class="row-fluid input-row">
					<label class="span3" for="name"><?php echo lang('keywords:name');?> <span>*</span></label>
					<div class="input span9">
						<?php echo form_input('name', $keyword->name);?>
					</div>
				</li>
		    </ul>
		    
		</div>
		
		
		<div class="btn-group padded">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
		</div>
			
		<?php echo form_close();?>

	</section>

	<script type="text/javascript">
		jQuery(function($) {
			$('form input[name="name"]').keyup($.debounce(100, function(){
				$(this).val( this.value.toLowerCase().replace(',', '') );
			}));
		});
	</script>


</div>
</section>
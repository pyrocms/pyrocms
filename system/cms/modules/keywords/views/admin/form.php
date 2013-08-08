<section class="padded">
<div class="container-fluid">


	<!-- Box -->
	<section class="box">

		<!-- Header -->
		<section class="box-header">
			<span class="title">
				<?php if ($this->method == 'edit'): ?>
					<?php echo sprintf(lang('keywords:edit_title'), $keyword->name) ?>
				<?php else: ?>
					<?php echo lang('keywords:add_title') ?>
				<?php endif ?>
			</span>
		</section>


		<!-- Box Content -->
		<section class="box-content">


			<?php echo form_open(uri_string(), 'class="crud"') ?>

			<fieldset class="padding-top">
				
			    <ul>
					<li class="row-fluid input-row">
						<label class="span3" for="name"><?php echo lang('keywords:name');?> <span>*</span></label>
						<div class="input span9"><?php echo form_input('name', $keyword->name);?></div>
					</li>
			    </ul>
			    
			</fieldset>
			    
			<div class="btn-group padded no-padding-bottom">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
			</div>	
				
			<?php echo form_close();?>


		</section>
		<!-- /Box Content -->

	</section>
	<!-- /Box -->

</div>
</section>


<script type="text/javascript">
	jQuery(function($) {
		$('form input[name="name"]').keyup($.debounce(100, function(){
			$(this).val( this.value.toLowerCase().replace(',', '') );
		}));
	});
</script>
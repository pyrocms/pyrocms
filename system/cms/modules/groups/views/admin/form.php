<?php if ($this->method == 'edit'): ?>
	<section class="title">
    	<h4><?php echo sprintf(lang('groups:edit_title'), $group->name) ?></h4>
	</section>
<?php else: ?>
	<section class="title">
    	<h4><?php echo lang('groups:add_title') ?></h4>
	</section>
<?php endif ?>

<section class="item">
	<div class="content">
		<?php echo form_open(uri_string(), 'class="crud"') ?>
		
		<div class="form_inputs">
		
		    <ul>
				<li>
					<label for="description"><?php echo lang('groups:name');?> <span>*</span></label>
					<div class="input"><?php echo form_input('description', $group->description);?></div>
				</li>
				
				<li class="even">
					<label for="name"><?php echo lang('groups:short_name');?> <span>*</span></label>
					
					<div class="input">
		
					<?php if ( ! in_array($group->name, array('user', 'admin'))): ?>
					<?php echo form_input('name', $group->name);?>
		
					<?php else: ?>
					<p><?php echo $group->name ?></p>
					<?php endif ?>
					
					</div>
				</li>
		    </ul>
		
		</div>
		
		<div class="buttons float-right padding-top">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
		</div>
			
		<?php echo form_close();?>
	</div>
</section>

<script type="text/javascript">
	jQuery(function($) {
		$('form input[name="description"]').keyup($.debounce(300, function(){

			var slug = $('input[name="name"]');

			$.post(SITE_URL + 'ajax/url_title', { title : $(this).val() }, function(new_slug){
				slug.val( new_slug );
			});
		}));
	});
</script>
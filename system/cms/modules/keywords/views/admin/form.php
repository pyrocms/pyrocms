<?php if ($this->method == 'edit'): ?>
    <h3><?php echo sprintf(lang('keywords:edit_title'), $keyword->name); ?></h3>
<?php else: ?>
    <h3><?php echo lang('keywords:add_title'); ?></h3>
<?php endif; ?>

<?php echo form_open(uri_string(), 'class="crud"'); ?>
    <ul>
		<li>
			<label for="name"><?php echo lang('keywords:name');?>:</label>
			<?php echo form_input('name', $keyword->name);?>
			<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
		</li>
    </ul>

	<div class="buttons">
		<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
	</div>
	
<?php echo form_close();?>

<script type="text/javascript">
	jQuery(function($) {
		$('form input[name="name"]').keyup($.debounce(100, function(){
			$(this).val( this.value.toLowerCase().replace(',', '') );
		}));
	});
</script>
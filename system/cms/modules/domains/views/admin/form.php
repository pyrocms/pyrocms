<section class="title">
<?php if($this->method == 'add'): ?>
	<h4><?php echo lang('domains:add_domain');?></h4>
<?php else: ?>
	<h4><?php echo lang('domains:edit_domain');?></h4>
<?php endif ?>
</section>

<section class="item">
	<div class="content">
	<?php echo form_open(uri_string(), 'class="crud"') ?>
	<div class="form_inputs">
		<ul>
			<li>
				<label for="from"><?php echo lang('domains:domain');?><small><?php echo lang('domains:domain_helper');?></small></label>
				<div class="input text">
					<?php echo form_input('domain', $domain->domain);?>
				</div>
			</li>
			<li>
				<label for="type"><?php echo lang('domains:type');?></label>
				<div class="input text">
					<?php echo form_dropdown('type', array('park' => lang('domains:park'), 'redirect' => lang('domains:redirect')), !empty($domain->type) ? $domain->type : 'park');?>
				</div>
			</li>
		</ul>

		<div class="buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
		</div>
	</div>
	<?php echo form_close() ?>
	</div>
</section>
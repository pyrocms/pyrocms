<section class="content-wrapper">
<div class="container-fluid">


	<section class="box">

		<section class="box-header">
			<span class="title"><?php echo sprintf(lang('comments:edit_title'), $comment->id) ?></span>
		</section>

		<?php echo form_open($this->uri->uri_string(), 'class="form_inputs"') ?>

			<?php echo form_hidden('user_id', $comment->user_id) ?>
			<?php echo form_hidden('active', $comment->is_active) ?>

			<ul class="form-inputs">
				
				<?php if ( ! $comment->user_id): ?>
				
				<li class="row-fluid input-row">
					<label class="span3" for="user_name"><?php echo lang('comments:name_label') ?>:</label>
					<div class="input span9">
						<?php echo form_input('user_name', $comment->user_name, 'maxlength="100"') ?>
					</div>
				</li>

				
				<li class="row-fluid input-row">
					<label class="span3" for="user_email"><?php echo lang('global:email') ?>:</label>
					<div class="input span9">
						<?php echo form_input('user_email', $comment->user_email, 'maxlength="100"') ?>
					</div>
				</li>

				<?php else: ?>

				<li class="row-fluid input-row">
					<label class="span3" for="user_name"><?php echo lang('comments:name_label') ?>:</label>
					<div class="input span9">
						<?php echo $comment->user_name ?>
					</div>
				</li>


				<li class="row-fluid input-row">
					<label class="span3" for="user_email"><?php echo lang('global:email') ?>:</label>
					<div class="input span9">
						<?php echo $comment->user_email ?>
					</div>
				</li>

				<?php endif; ?>

				<li class="row-fluid input-row">
					<label class="span3" for="user_website"><?php echo lang('comments:website_label') ?>:</label>
					<div class="input span9">
						<?php echo form_input('user_website', $comment->user_website) ?>
					</div>
				</li>

				<li class="row-fluid input-row">
					<label class="span3" for="comment"><?php echo lang('comments:message_label') ?>:</label>
					<div class="input span9">
						<?php echo form_textarea(array('name'=>'comment', 'value' => $comment->comment, 'rows' => 5)) ?>
					</div>
				</li>
			</ul>

			<div class="btn-group form-button-group">
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )) ?>
			</div>

		<?php echo form_close() ?>

	</section>

</div>
</section>
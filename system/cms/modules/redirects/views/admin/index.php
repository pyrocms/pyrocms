<section class="padded">
<div class="container-fluid">


	<!-- Box -->
	<section class="box">

		<!-- Header -->
		<section class="box-header">
			<span class="title"><?php echo lang('redirects:list_title') ?></span>
		</section>


		<!-- Box Content -->
		<section class="box-content">


			<?php if ($redirects): ?>

				
			    <?php echo form_open('admin/redirects/delete') ?>
					
					<table class="table table-hover table-striped">
					    
					    <thead>
							<tr>
								<th width="15"><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
								<th width="25"><?php echo lang('redirects:type');?></th>
								<th width="25%"><?php echo lang('redirects:from');?></th>
								<th><?php echo lang('redirects:to');?></th>
								<th width="200"></th>
							</tr>
					    </thead>
						
						<tbody>
						<?php foreach ($redirects as $redirect): ?>
						    <tr>
							<td><?php echo form_checkbox('action_to[]', $redirect->id) ?></td>
							<td><?php echo $redirect->type;?></td>
							<td><?php echo str_replace('%', '*', $redirect->from);?></td>
							<td><?php echo $redirect->to;?></td>
							<td class="text-center">
							<div class="actions">
							    <?php echo anchor('admin/redirects/edit/' . $redirect->id, lang('redirects:edit'), 'class="button edit"');?>
								<?php echo anchor('admin/redirects/delete/' . $redirect->id, lang('redirects:delete'), array('class'=>'confirm button delete'));?>
							</div>
							</td>
						    </tr>
						<?php endforeach ?>
					    </tbody>

					</table>
				
					<div class="btn-group">
						<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )) ?>
					</div>

			    <?php echo form_close() ?>


			    <?php $this->load->view('admin/partials/pagination') ?>


			<?php else: ?>
				
				<div class="alert margin"><?php echo lang('redirects:no_redirects');?></div>
				
			<?php endif ?>


		</section>
		<!-- /Box Content -->

	</section>
	<!-- /Box -->

</div>
</section>
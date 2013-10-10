<!-- .modal-dialog -->
<div class="modal-dialog">

	<!-- .modal-content -->
	<div class="modal-content">


		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h4 class="modal-title"><?php echo $email_template->subject ?></h4>
		</div>
		
		<div class="modal-body">
			<?php echo $email_template->body ?>
		</div>

	</div>
	<!-- /.modal-content -->

</div>
<!-- /.modal-dialog -->
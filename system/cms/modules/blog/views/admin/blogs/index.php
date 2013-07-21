<section class="padded">
<div class="container-fluid">


	<!-- Box -->
	<section class="box">

		<!-- Header -->
		<section class="box-header">
			<span class="title"><?php echo lang('blog:blogs_title') ?></span>
		</section>


		<!-- Box Content -->
		<section class="box-content">


			<?php if ($blogs): ?>
			
				<table class="table table-hover table-striped">
					<thead>
					<tr>
						<th><?php echo lang('blog:blog_title') ?></th>
						<th><?php echo lang('global:slug') ?></th>
						<th width="120"></th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($blogs as $blog): ?>
					<tr>
						<td><?php echo lang_label($blog->stream_name); ?></td>
						<td><?php echo $blog->blog_uri; ?></td>
						<td>
							<a href="" class="btn">Edit</a>
							<a href="" class="btn">Delete</a>
							<a href="" class="btn">New Post</a>
						</td>
					</tr>
					<?php endforeach; ?>
					</tbody>
				</table>

				<?php echo form_close() ?>

				<?php $this->load->view('admin/partials/pagination') ?>

			<?php else: ?>
				<div class="alert margin">No blogs</div>
			<?php endif ?>


		</section>
		<!-- /Box Content -->

	</section>
	<!-- /Box -->

</div>
</section>
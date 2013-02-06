<section class="title">
	<h4><?php echo lang('blog:blogs_title') ?></h4>
</section>

<section class="item">
	<div class="content">

	<?php if ($blogs): ?>
	
		<table border="0" class="table-list" cellspacing="0">
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
		<div class="no_data">No blogs</div>
	<?php endif ?>
	</div>
</section>
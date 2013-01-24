<section class="title">
	<h4><?php echo lang('global:delete'); ?> <?php echo lang('page_types:list_title_sing'); ?></h4>
</section>

<section class="item">
	<div class="content">

		<?php echo form_open($this->uri->uri_string()); ?>
	
			<p><?php echo sprintf(lang('page_types:delete_message'), $num_of_pages); ?></p>
	
			<?php if ($delete_stream): ?>
				<p><?php echo sprintf(lang('page_types:delete_streams_message'), $stream_name); ?></p>
			<?php endif; ?>
	
			<input type="hidden" name="do_delete" value="y" />
	
			<p>
				<button type="submit" class="btn red"><?php echo lang('global:delete'); ?></button>
				<a href="<?php echo site_url('admin/pages/types'); ?>" class="btn gray"><?php echo lang('cancel_label'); ?></a>
			</p>
	
		</form>

	</div>
</section>
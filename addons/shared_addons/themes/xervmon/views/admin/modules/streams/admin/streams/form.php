<div class="accordion-group">
<section class="title accordion-heading">
<?php if($method == 'new'): ?>
	<h4><?php echo lang('streams:add_stream');?></h4>
<?php else: ?>
	<h4><?php echo lang('streams:edit_stream');?></h4>
<?php endif; ?>
</section>

<?php echo form_open(uri_string(), 'class="crud"'); ?>
<section class="accordion-body collapse in lstnav">
<div class="content">

<div class="form_inputs">

	<ul>
		<li>
			<label for="stream_name"><?php echo lang('streams:stream_name'); ?> <span>*</span></label>
			<div class="input"><?php echo form_input('stream_name', $stream->stream_name, 'maxlength="60" autocomplete="off" id="stream_name"'); ?>
		</li>

		<li>
			<label for="about"><?php echo lang('streams:about_stream'); ?><small><?php echo lang('streams:about_instructions'); ?></small></label>
			<div class="input"><?php echo form_input('about', $stream->about, 'maxlength="255"'); ?></div>
		</li>

		<li>
			<label for="stream_slug"><?php echo lang('streams:stream_slug'); ?> <span>*</span><small><?php echo lang('streams:slug_instructions'); ?></small></label>
			<div class="input"><?php echo form_input('stream_slug', $stream->stream_slug, 'maxlength="60" id="stream_slug"'); ?></div>
		</li>

		<li>
			<label for="stream_slug"><?php echo lang('streams:stream_prefix'); ?> <small><?php echo lang('streams:prefix_instructions'); ?></small></label>
			<div class="input"><?php echo form_input('stream_prefix', $stream->stream_prefix, 'maxlength="60" id="stream_prefix"'); ?></div>
		</li>

		<li>
			<label for="stream_slug"><?php echo lang('streams:menu_path'); ?> <small><?php echo lang('streams:menu_path_instructions'); ?></small></label>
			<div class="input"><?php echo form_input('menu_path', $stream->menu_path, 'maxlength="255" id="menu_path"'); ?></div>
		</li>


		<?php if( $method == 'edit' ): ?>

		<li>
			<label for="title_column"><?php echo lang('streams:title_column');?></label>
			<div class="input"><?php echo form_dropdown('title_column', $fields, $stream->title_column); ?></div>
		</li>

		<li>
			<label for="sorting"><?php echo lang('streams:sort_method');?></label>
			<div class="input"><?php echo form_dropdown('sorting', array('title'=>lang('streams:by_title_column'), 'custom'=>lang('streams:manual_order')), $stream->sorting); ?></div>
		</li>
		
		<?php endif; ?>
			
	</ul>

	<div class="float-right buttons">
		<button type="submit" name="btnAction" value="save" class="btn btn-primary"><span><?php echo lang('buttons:save'); ?></span></button>	
		
		<?php if($this->uri->segment(3)=='add'): ?>

			<a href="<?php echo site_url('admin/streams'); ?>" class="btn gray"><?php echo lang('buttons:cancel'); ?></a>
		
		<?php else: ?>
		
			<a href="<?php echo site_url('admin/streams/manage/'.$stream->id); ?>" class="btn gray"><?php echo lang('buttons:cancel'); ?></a>
		
		<?php endif; ?>
	</div>
		
</div>
</section>		
		
<?php echo form_close();?>	
</div>
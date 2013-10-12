<div class="form-group">
	<label for="restricted_to[]"><?php echo lang('pages:access_label') ?></label>
	<?php echo form_multiselect('restricted_to[]', array(0 => lang('global:select-any')) + $group_options, $page->restricted_to, 'size="'.(($count = count($group_options)) > 1 ? $count : 2).'"') ?>
</div>

<?php if ( ! module_enabled('comments')): ?>
<?php echo form_hidden('comments_enabled'); ?>
<?php else: ?>
<div class="checkbox">
	<label>
		<?php echo form_checkbox('comments_enabled', true, $page->comments_enabled == true, 'id="comments_enabled"') ?>
		<?php echo lang('pages:comments_enabled_label') ?>
	</label>
</div>
<?php endif; ?>

<div class="checkbox">
	<label>
		<?php echo form_checkbox('rss_enabled', true, $page->rss_enabled == true, 'id="rss_enabled"') ?>
		<?php echo lang('pages:rss_enabled_label') ?>
	</label>
</div>

<div class="checkbox">
	<label>
		<?php echo form_checkbox('is_home', true, $page->is_home == true, 'id="is_home"') ?>
		<?php echo lang('pages:is_home_label') ?>
	</label>
</div>

<div class="checkbox">
	<label>
		<?php echo form_checkbox('strict_uri', 1, $page->strict_uri == true, 'id="strict_uri"') ?>
		<?php echo lang('pages:strict_uri_label') ?>
	</label>
</div>
<ul>
    <li>
        <label for="restricted_to[]"><?php echo lang('pages:access_label') ?></label>
        <div class="input"><?php echo form_multiselect('restricted_to[]', array(0 => lang('global:select-any')) + $group_options, $page->restricted_to, 'size="'.(($count = count($group_options)) > 1 ? $count : 2).'"') ?></div>
    </li>

    <?php if ( ! module_enabled('comments')): ?>
        <?php echo form_hidden('comments_enabled'); ?>
    <?php else: ?>
        <li>
            <label for="comments_enabled"><?php echo lang('pages:comments_enabled_label') ?></label>
            <div class="input"><?php echo form_checkbox('comments_enabled', true, $page->comments_enabled == true, 'id="comments_enabled"') ?></div>
        </li>
    <?php endif; ?>

    <li>
        <label for="rss_enabled"><?php echo lang('pages:rss_enabled_label') ?></label>
        <div class="input"><?php echo form_checkbox('rss_enabled', true, $page->rss_enabled == true, 'id="rss_enabled"') ?></div>
    </li>

    <li>
        <label for="is_home"><?php echo lang('pages:is_home_label') ?></label>
        <div class="input"><?php echo form_checkbox('is_home', true, $page->is_home == true, 'id="is_home"') ?></div>
    </li>

    <li>
        <label for="strict_uri"><?php echo lang('pages:strict_uri_label') ?></label>
        <div class="input"><?php echo form_checkbox('strict_uri', 1, $page->strict_uri == true, 'id="strict_uri"') ?></div>
    </li>
</ul>

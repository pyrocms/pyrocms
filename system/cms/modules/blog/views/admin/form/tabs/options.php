<fieldset>

    <ul>

        <li>
            <label for="category_id"><?php echo lang('blog:category_label') ?></label>
            <div class="input">
            <?php echo form_dropdown('category_id', array(lang('blog:no_category_select_label')) + $categories, @$post->category_id) ?>
                [ <?php echo anchor('admin/blog/categories/create', lang('blog:new_category_label'), 'target="_blank"') ?> ]
            </div>
        </li>

        <?php if ( ! module_enabled('keywords')): ?>
            <?php echo form_hidden('keywords'); ?>
        <?php else: ?>
            <li>
                <label for="keywords"><?php echo lang('global:keywords') ?></label>
                <div class="input"><?php echo form_input('keywords', $post->keywords, 'id="keywords"') ?></div>
            </li>
        <?php endif; ?>

        <li class="date-meta">
            <label><?php echo lang('blog:date_label') ?></label>
            <div class="input datetime_input">
                <?php echo form_input('created_at', date('Y-m-d', strtotime($post->created_at)), 'maxlength="10" id="datepicker" class="text width-20"') ?> &nbsp;
                <?php echo form_dropdown('created_at_hour', $hours, date('H', strtotime($post->created_at))) ?> :
                <?php echo form_dropdown('created_at_minute', $minutes, date('i', ltrim(strtotime($post->created_at), '0'))) ?>
            </div>
        </li>

        <?php if ( ! module_enabled('comments')): ?>
            <?php echo form_hidden('comments_enabled', 'no'); ?>
        <?php else: ?>
            <li>
                <label for="comments_enabled"><?php echo lang('blog:comments_enabled_label');?></label>
                <div class="input">
                    <?php echo form_dropdown('comments_enabled', array(
                        'no' => lang('global:no'),
                        '1 day' => lang('global:duration:1-day'),
                        '1 week' => lang('global:duration:1-week'),
                        '2 weeks' => lang('global:duration:2-weeks'),
                        '1 month' => lang('global:duration:1-month'),
                        '3 months' => lang('global:duration:3-months'),
                        'always' => lang('global:duration:always'),
                    ), $post->comments_enabled ?: '3 months') ?>
                </div>
            </li>
        <?php endif; ?>

    </ul>

</fieldset>

<fieldset>
    <ul>
        <li>
            <label for="title"><?php echo lang('global:title') ?> <span>*</span></label>
            <div class="input"><?php echo form_input('title', htmlspecialchars_decode($post->title), 'maxlength="100" id="title"') ?></div>
        </li>

        <li>
            <label for="slug"><?php echo lang('global:slug') ?> <span>*</span></label>
            <div class="input"><?php echo form_input('slug', $post->slug, 'maxlength="100" class="width-20"') ?></div>
        </li>

        <li>
            <label for="status"><?php echo lang('blog:status_label') ?></label>
            <div class="input"><?php echo form_dropdown('status', array('draft' => lang('blog:draft_label'), 'live' => lang('blog:live_label')), $post->status) ?></div>
        </li>

        <li class="editor">
            <label for="body"><?php echo lang('blog:content_label') ?> <span>*</span></label><br>
            <div class="input small-side">
                <?php echo form_dropdown('type', array(
                    'html' => 'html',
                    'markdown' => 'markdown',
                    'wysiwyg-simple' => 'wysiwyg-simple',
                    'wysiwyg-advanced' => 'wysiwyg-advanced',
                ), $post->type) ?>
            </div>

            <div class="edit-content">
                <?php echo form_textarea(array('id' => 'body', 'name' => 'body', 'value' => $post->body, 'rows' => 30, 'class' => $post->type)) ?>
            </div>
        </li>

    </ul>

    <?php echo form_hidden('preview_hash', $post->preview_hash)?>

</fieldset>

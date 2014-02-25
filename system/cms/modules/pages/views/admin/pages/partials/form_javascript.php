<ul>
    <li class="<?php echo alternator('', 'even') ?>">
        <label for="js"><?php echo lang('pages:js_label') ?></label><br />
        <div>
            <?php echo form_textarea('js', $page->js, 'class="js_editor"') ?>
        </div>
    </li>
</ul>

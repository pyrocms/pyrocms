<?php echo form_open_multipart($formUrl, 'class="streams_form"'); ?>

<div class="tabs">

    <ul class="tab-menu">
    <?php foreach($tabs as $tab): ?>
        <li>
            <a href="#<?php echo $tab['id']; ?>" title="<?php echo $tab['title']; ?>">
                <span><?php echo $tab['title']; ?></span>
            </a>
        </li>
    <?php endforeach; ?>
    </ul>

    <?php foreach($tabs as $tab): ?>

    <div class="form_inputs" id="<?php echo $tab['id']; ?>">

        <?php if ( ! empty($tab['content']) and is_string($tab['content'])): ?>

            <?php echo $tab['content']; ?>

        <?php else: ?>

            <fieldset>

                <ul>

                <?php if (is_array($tab['fields'])): ?>

                    <?php foreach ($tab['fields'] as $slug): ?>

                        <?php if ($field = $fields->findBySlug($slug)): ?>
                            <li class="<?php echo in_array($field->field_slug, $hidden) ? 'hidden' : null; ?>">
                                <?php echo $field->input_row; ?>
                            </li>
                        <?php endif; ?>

                    <?php endforeach; ?>

                <?php endif; ?>

                </ul>

            </fieldset>

        <?php endif; ?>

    </div>

    <?php endforeach; ?>

</div>

    <?php if (!$new) { ?><input type="hidden" value="<?php echo $entry->id;?>" name="row_edit_id" /><?php } ?>

    <div class="float-right buttons">
        <button type="submit" name="btnAction" value="save" class="btn green"><?php echo lang('buttons:save'); ?></button>

        <?php if (! empty($redirectCreate)): ?>
        <button type="submit" name="btnAction" value="create" class="btn green"><?php echo lang('buttons:save_create'); ?></button>
        <?php endif; ?>

        <?php if (! empty($redirectContinue)): ?>
        <button type="submit" name="btnAction" value="continue" class="btn green"><?php echo lang('buttons:save_continue'); ?></button>
        <?php endif; ?>

        <?php if (! empty($redirectExit)): ?>
        <button type="submit" name="btnAction" value="exit" class="btn green"><?php echo lang('buttons:save_exit'); ?></button>
        <?php endif; ?>

        <a href="<?php echo site_url($uriCancel ?: 'admin/streams/entries/index/'.$stream->id); ?>" class="btn gray"><?php echo lang('buttons:cancel'); ?></a>
    </div>

<?php echo form_close();

<?php echo form_open(uri_string()); ?>

<div class="form_inputs">

    <ul>

        <li>
            <label for="field_name"><?php echo lang('streams:label.field_name');?> <span>*</span></label>
            <div class="input">
                <?php

                if ($currentField->isFieldNameLang()) {
                    echo '<p><em>'.$currentField->field_name.'</em></p>';
                    echo form_hidden('field_name', $currentField->field_name);
                } else {
                    echo form_input('field_name', $currentField->field_name, 'maxlength="60" id="field_name" autocomplete="off"');
                }

                ?></div>

        </li>

        <li>
            <label for="field_slug"><?php echo lang('streams:label.field_slug');?> <span>*</span><br /><small><?php echo lang('global:slug_instructions'); ?></small></label>
            <div class="input"><?php echo form_input('field_slug', $currentField->field_slug, 'maxlength="60" id="field_slug"'); ?></div>
        </li>

        <?php if (isset($stream)): ?>



            <li>
                <label for="required"><?php echo lang('streams:label.field_required');?></label>
                <div class="input"><?php echo form_checkbox('is_required', 'yes', isset($assignment) ? $assignment->is_required : false, 'id="required"');?></div>
            </li>


            <li>
                <label for="unique"><?php echo lang('streams:label.field_unique');?></label>
                <div class="input"><?php echo form_checkbox('is_unique', 'yes', isset($assignment) ? $assignment->is_unique : false, 'id="unique"'); ?></div>
            </li>

            <li>
                <label for="field_instructions"><?php echo lang('streams:label.field_instructions');?><br /><small><?php echo lang('streams:instr.field_instructions');?></small></label>
                <div class="input"><?php echo form_textarea('instructions', isset($assignment) ? $assignment->instructions : null, 'id="field_instructions"');?></div>
            </li>

            <?php if ($allow_title_column_set): ?>
                <li>
                    <label for="title_column"><?php echo lang('streams:label.make_field_title_column');?></label>
                    <div class="inputs"><?php echo form_checkbox('title_column', 'yes', $title_column_status, 'id="title_column"');?></div>
                </li>
            <?php endif; ?>

        <?php endif; ?>

        <?php

            // We send some special params in an edit situation
            $ajax_url = 'streams/ajax/build_parameters';

            if($this->uri->segment(4) == 'edit'):

                $ajax_url .= '/edit/'.$currentField->id;

            endif;

        ?>

        <li>
            <label for="field_type"><?php echo lang('streams:label.field_type'); ?> <span>*</span></label>
            <div class="input"><?php echo form_dropdown('field_type', $field_types, $currentField->field_type, 'data-placeholder="'.lang('streams:choose_a_field_type').'" id="field_type"'); ?></div>
        </li>

        <div id="parameters">

            <?php echo $parameters; ?>

        </div>

    </ul>

        <div class="float-right buttons">

        <button type="submit" name="btnAction" value="save" class="btn blue"><span><?php echo lang('buttons:save'); ?></span></button>

        <?php if ($uriCancel): ?>
            <a href="<?php echo site_url($uriCancel); ?>" class="btn gray cancel"><?php echo lang('buttons:cancel'); ?></a>
        <?php endif; ?>

    </div>

<?php echo form_close();

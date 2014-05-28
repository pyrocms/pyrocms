<label for="<?php echo $field_type->form_slug;?>"><?php echo lang_label($field_type->getField()->field_name);?>

    <?php if($field_type->getField()->is_required): ?><span class="required">*</span><?php endif; ?>

    <?php if( ! empty($field_type->getField()->instructions)): ?>
        <br /><small><?php echo lang_label($field_type->getField()->instructions); ?></small>
    <?php endif; ?>

</label>

<div class="input" id="category">
    <?php echo $field_type->getInput(); ?>

    [ <?php echo anchor('admin/blog/categories/create_ajax', lang('blog:new_category_label'), 'target="_blank" id="category-shortcut"') ?> ]
</div>

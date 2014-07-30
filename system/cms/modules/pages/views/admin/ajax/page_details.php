<input id="page-id" type="hidden" value="<?php echo $page->id ?>"/>
<input id="page-uri" type="hidden"
       value="<?php echo (!empty($page->entry->uri)) ? $page->entry->uri : $page->entry->slug ?>"/>

<fieldset>
    <legend><?php echo lang('pages:detail_label') ?></legend>
    <p>
        <strong>ID:</strong> #<?php echo $page->id ?>
    </p>

    <p>
        <strong><?php echo lang('pages:status_label') ?>:</strong> <?php echo lang("pages:{$page->status}_label") ?>
    </p>

    <p>
        <strong><?php echo lang('global:slug') ?>:</strong>
        <a href="<?php echo !empty($page->entry->uri) ? $page->entry->uri : $page->entry->slug ?>" target="_blank">
            /<?php echo !empty($page->entry->uri) ? $page->entry->uri : $page->entry->slug ?>
        </a>
    </p>

    <p>
        <strong><?php echo lang('pages:type_id_label') ?>:</strong>
        <?php echo $page->type->title; ?>
    </p>
</fieldset>

<!-- Meta data tab -->
<?php if ($page->entry->meta_title or $page->entry->metaKeywords() or $page->entry->meta_description): ?>
    <fieldset>
        <legend><?php echo lang('pages:meta_label') ?></legend>
        <?php if ($page->entry->meta_title): ?>
            <p>
                <strong><?php echo lang('pages:meta_title_label') ?>:</strong> <?php echo $page->entry->meta_title ?>
            </p>
        <?php endif ?>
        <?php if ($page->entry->metaKeywords()): ?>
            <p>
                <strong><?php echo lang('pages:meta_keywords_label') ?>:</strong> <?php echo implode(
                    ', ',
                    $page->entry->metaKeywords()->lists('name')
                ) ?>
            </p>
        <?php endif ?>
        <?php if ($page->entry->meta_description): ?>
            <p>
                <strong><?php echo lang('pages:meta_desc_label') ?>
                    :</strong> <?php echo $page->entry->meta_description ?>
            </p>
        <?php endif ?>
    </fieldset>
<?php endif ?>

<div class="buttons">
    <?php

    if ($this->db->count_all('page_types') > 1) {
        echo anchor(
            'admin/pages/choose_type?modal=true&parent=' . $page->id,
            lang('pages:create_label'),
            'class="button modal"'
        );
    } else {
        $type_id = $this->db->select('id')->limit(1)->get('page_types')->row()->id;
        echo anchor(
            'admin/pages/create?parent=' . $page->id . '&page_type=' . $type_id,
            lang('pages:create_label'),
            'class="button"'
        );
    }

    ?>
    <?php echo anchor('admin/pages/duplicate/' . $page->id, lang('pages:duplicate_label'), 'class="button"') ?>
    <?php echo anchor('admin/pages/edit/' . $page->id, lang('global:edit'), 'class="button"') ?>
    <?php echo anchor('admin/pages/delete/' . $page->id, lang('global:delete'), 'class="confirm button"') ?>
</div>

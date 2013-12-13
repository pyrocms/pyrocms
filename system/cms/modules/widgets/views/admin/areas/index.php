<?php if (! $this->input->is_ajax_request()): ?>
    <section class="title">
        <h4><?php echo lang('widgets:areas') ?></h4>
    </section>

    <section class="item">
        <div class="content">
        <?php endif ?>

            <?php foreach ($areas as $area): ?>
            <section class="widget-area-box">
                <header>
                    <h3><?php echo $area->name ?></h3>
                </header>
                <div class="widget-area-content">
                    <div class="area-buttons buttons buttons-small">

                        <?php echo anchor('admin/widgets/areas/edit/'.$area->slug, lang('global:edit'), 'class="button edit"') ?>
                        <button type="submit" name="btnAction" value="delete" class="button delete confirm"><span><?php echo lang('global:delete') ?></span></button>

                    </div>

                    <!-- Widget Area Tag -->
                    <input type="text" class="widget-section-code widget-code" value='<?php echo sprintf('{{ widgets:area slug="%s" }}', $area->slug) ?>' />

                </div>
            </section>
            <?php endforeach ?>

        <?php if (! $this->input->is_ajax_request()): ?>
        </div>
    </section>
<?php endif ?>

<div class="one_half" id="available-widgets">
    <section class="title">
        <h4><?php echo lang('widgets:available_title') ?></h4>
    </section>
    <section class="item">
        <div class="content">
            <?php if ($available_widgets): ?>
            <ul>
                <?php foreach ($available_widgets as $widget): ?>
                <li id="widget-<?php echo $widget->slug ?>" class="widget-box">
                    <p><span><?php echo $widget->name ?></span> <?php echo $widget->description ?></p>
                    <div class="widget_info" style="display: none;">
                        <p class="author"><?php echo lang('widgets:widget_author') . ': ' . ($widget->website ? anchor($widget->website, $widget->author, array('target' => '_blank')) : $widget->author) ?>
                    </div>
                </li>
                <?php endforeach ?>
            </ul>
            <?php else: ?>
            <p><?php echo lang('widgets:no_available_widgets') ?></p>
            <?php endif ?>
        </div>
    </section>
</div>

<div class="one_half last" id="widget-areas">
    <section class="title">
        <h4><?php echo lang('widgets:widget_area_wrapper') ?></h4>
    </section>
    <section class="item">
        <div class="content">
            <?php if ($areas): ?>
            <!-- Available Widget Areas -->
            <div id="widget-areas-list">

                <?php foreach ($areas as $area): ?>
                <section class="widget-area-box js-widget-area" id="area-<?php echo $area->slug ?>" data-id="<?php echo $area->id ?>">
                    <header>
                        <h3><?php echo $area->name ?></h3>
                    </header>
                    <div class="widget-area-content accordion-content">
                        <div class="area-buttons buttons buttons-small">

                            <?php echo anchor('admin/widgets/areas/edit/'.$area->slug, lang('global:edit'), 'class="button edit"') ?>
                            <button type="submit" name="btnAction" value="delete" class="button delete confirm"><span><?php echo lang('global:delete') ?></span></button>

                        </div>

                        <!-- Widget Area Tag -->
                        <input type="text" class="widget-section-code widget-code" value='<?php echo sprintf('{{ widgets:area slug="%s" }}', $area->slug) ?>' />

                        <!-- Widget Area Instances -->
                        <div class="widget-list">
                            <?php $this->load->view('admin/instances/index', array('instances' => $area->instances)) ?>
                            <div style="clear:both"></div>
                        </div>
                    </div>
                </section>
                <?php endforeach ?>

            </div>
            <?php else: ?>
                <?php echo anchor('admin/widgets/areas/create', lang('widgets:add_area'), 'class="add create-area"') ?>
            <?php endif ?>
        </div>
    </section>
</div>

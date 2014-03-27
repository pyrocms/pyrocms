<ol>
    <?php if ($instances): ?>
        <?php foreach ($instances as $instance): ?>
            <li id="instance-<?php echo $instance->id; ?>" class="widget-instance">
                <h4><span><?php echo $instance->widget->name; ?>:</span> <?php echo $instance->name; ?></h4>

                <div class="widget-actions buttons buttons-small">
                    <?php $this->load->view(
                        'admin/partials/buttons',
                        array(
                            'button_type' => 'secondary',
                            'buttons'     => array(
                                'edit' => array('id' => $instance->id),
                                'delete'
                            )
                        )
                    ) ?>
                    <button class="button instance-code"
                            id="instance-code-<?php echo $instance->id; ?>"><?php echo lang(
                            'widgets:view_code'
                        ); ?></button>
                </div>
                <div id="instance-code-<?php echo $instance->id; ?>-wrap" style="display: none;">
                    <input type="text" class="widget-code"
                           value='{{ widgets:instance id="<?php echo $instance->id; ?>"}}'/>
                </div>
                <div style="clear:both"></div>
            </li>
        <?php endforeach; ?>
    <?php endif; ?>
    <li class="empty-drop-item no-sortable"></li>
</ol>

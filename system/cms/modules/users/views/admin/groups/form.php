<?php file_partial('notices'); ?>

<div class="p">

    <!-- .panel -->
    <section class="panel panel-default animated-zing fadeIn n-m">

        <div class="panel-heading">
            <h3 class="panel-title">
                <?php if ($this->method == 'edit'): ?>
                    <section class="title">
                        <h4><?php echo sprintf(lang('users:groups:edit_title'), $group->name) ?></h4>
                    </section>
                <?php else: ?>
                    <section class="title">
                        <h4><?php echo lang('users:groups:add_title') ?></h4>
                    </section>
                <?php endif ?>
            </h3>
        </div>

        <section class="p">
            <?php echo form_open(null, 'class="streams_form"') ?>

            <div class="form-group">
                <div class="row">
                    <label for="description" class="col-lg-2 control-label">
                        <?php echo lang('global:email') ?> <span>*</span>
                    </label>

                    <div class="col-lg-10">
                        <?php echo form_input('description', $group->description, 'class="form-control"') ?>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <label for="description" class="col-lg-2 control-label">
                        <?php echo lang('users:groups:short_name') ?> <span>*</span>
                    </label>

                    <div class="col-lg-10">
                        <?php if (!in_array($group->name, array('user', 'admin'))): ?>
                            <?php echo form_input('name', $group->name, 'class="form-control"') ?>

                        <?php else: ?>
                            <p><?php echo $group->name; ?></p>
                            <?php echo form_hidden('name', $group->name); ?>
                        <?php endif ?>
                    </div>
                </div>
            </div>

            <script type="text/javascript">
                jQuery(function ($) {
                    Pyro.GenerateSlug('input[name="description"]', 'input[name="name"]');
                });
            </script>
        </section>

        <!--
            Table of Roles
        -->
        <?php if ($group->name != 'admin'): ?>
            <?php echo form_open() ?>
            <table class="table">
                <thead>
                <tr>
                    <th><?php echo form_checkbox(
                            array(
                                'id'    => 'check-all',
                                'name'  => 'action_to_all',
                                'class' => 'check-all',
                                'title' => lang('permissions:checkbox_tooltip_action_to_all')
                            )
                        ) ?></th>
                    <th><?php echo lang('permissions:module') ?></th>
                    <th><?php echo lang('permissions:roles') ?></th>
                </tr>
                </thead>
                <tbody>

                <tr>
                    <td style="width: 30px">
                        <?php echo form_checkbox(
                            array(
                                'value'   => 'admin',
                                'name'    => 'modules[]',
                                'checked' => $group->hasAccess('admin.general'),
                                'title'   => lang('global:dashboard'),
                                'class'   => 'js-perm-module',
                            )
                        ) ?>
                    </td>
                    <td>
                        <label class="inline" for="dashboard">
                            <?php echo lang('global:dashboard') ?>
                        </label>
                    </td>
                    <td>
                        <!-- None -->
                    </td>
                </tr>

                <?php foreach ($modules as $module): ?>

                    <tr>
                        <td style="width: 30px">
                            <?php echo form_checkbox(
                                array(
                                    'value'   => $module['slug'],
                                    'name'    => 'modules[]',
                                    'checked' => $group->hasAccess($module['slug'] . '.*'),
                                    'title'   => sprintf(
                                        lang('permissions:checkbox_tooltip_give_access_to_module'),
                                        $module['name']
                                    ),
                                    'class'   => 'js-perm-module',
                                )
                            ) ?>
                        </td>
                        <td>
                            <label class="inline" for="<?php echo $module['slug'] ?>">
                                <?php echo $module['name'] ?>
                            </label>
                        </td>
                        <td>
                            <?php if (!empty($module['roles'])): ?>
                                <?php foreach ($module['roles'] as $role): ?>
                                    <label class="inline">
                                        <?php echo form_checkbox(
                                            array(
                                                'name'    => 'module_roles[' . $module['slug'] . '][]',
                                                'value'   => $role,
                                                'checked' => $group->hasAccess(
                                                        $module['slug'] . '.' . $role
                                                    ),
                                                'class'   => 'js-perm-role',
                                            )
                                        ) ?>
                                        <?php echo lang($module['slug'] . ':role_' . $role) ?>
                                    </label>
                                <?php endforeach ?>
                            <?php endif ?>

                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>

            <div class="panel-footer">
                <?php $this->load->view(
                    'admin/partials/buttons',
                    array('buttons' => array('save', 'save_exit', 'cancel'))
                ) ?>
            </div>
        <?php else: ?>

            <!-- @todo - language string -->
            Administrators can do anything.

        <?php endif; ?>

        <?php echo form_close() ?>

    </section>
</div>
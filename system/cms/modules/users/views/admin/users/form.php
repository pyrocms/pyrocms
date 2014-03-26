<fieldset>
<ul>
    <li class="even">
        <label for="email"><?php echo lang('global:email') ?> <span>*</span></label>
        <div class="input">
            <?php echo form_input('email', $member->email, 'id="email"') ?>
        </div>
    </li>

    <li>
        <label for="username"><?php echo lang('user:username') ?> <span>*</span></label>
        <div class="input">
            <?php echo form_input('username', $member->username, 'id="username"') ?>
        </div>
    </li>

    <?php if ( ! $member->isSuperUser() or ($member->isSuperUser() and $current_user->id != $member->id)): ?>

        <?php if ( ! empty($group_options)): ?>
            <li>
                <label for="group_id"><?php echo lang('user:group_label') ?></label>
                <div class="input">
                    <?php echo form_multiselect('groups[]', $group_options, $member->getCurrentGroupIds()); ?>
                </div>
            </li>
        <?php endif; ?>

        <li class="even">
            <label for="active"><?php echo lang('user:activate_label') ?> <span>*</span></label>
            <div class="input">
                <?php $options = array(0 => lang('user:do_not_activate'), 1 => lang('user:active'), 2 => lang('user:send_activation_email')) ?>
                <?php echo form_dropdown('active', $options, $member->is_activated, 'id="active"') ?>
            </div>
        </li>

        <li class="even">
            <label for="active"><?php echo lang('user:blocked_label') ?> <span>*</span></label>
            <div class="input">
                <?php $options = array(0 => lang('user:do_not_block'), 1 => lang('user:blocked')) ?>
                <?php echo form_dropdown('blocked', $options, $member->is_blocked, 'id="blocked"') ?>
            </div>
        </li>

    <?php endif; ?>

    <li class="even">
        <label for="password">
            <?php echo lang('global:password') ?>
            <?php if ( ! $member->getKey()): ?> <span>*</span><?php endif ?>
        </label>
        <div class="input">
            <?php echo form_password('password', '', 'id="password" autocomplete="off"'); ?>
        </div>
    </li>
</ul>
</fieldset>

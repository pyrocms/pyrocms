<section class="title">
    <h3>{step3_header}</h3>
</section>

<section class="item">
    <p>{step3_intro_text}</p>
</section>

<section class="title">
    <h3>{folder_perm}</h3>
</section>

<section class="item">
    <ul class="permissions folders">
        <?php foreach ($permissions['directories'] as $directory => $status): ?>
            <li>
                <span><?php echo $directory ?></span>
            <?php echo $status ? '<em class="pass">{writable}</em>' : '<em class="fail">{not_writable}</em>' ?>
            </li>
        <?php endforeach ?>
    </ul>

    <p>
        <a href="#" id="show-commands">+ <?php echo lang('show_commands') ?></a>
        <a href="#" id="hide-commands" style="display:none">- <?php echo lang('hide_commands') ?></a>
    </p>

    <textarea id="commands" style="display:none; background-color: #111; color: limegreen;" rows="<?php echo count($permissions['directories']) ?>">
    <?php
    foreach ($permissions['directories'] as $directory => $status) {
        echo $status ? '' : 'chmod 777 '.$directory.PHP_EOL;
    }
    ?>
    </textarea>

    <?php if($step_passed): ?>
        <a class="btn orange" id="next_step" href="<?php echo site_url('installer/step_4') ?>" title="{next_step}">{step4}</a>
    <?php else: ?>
        <a class="btn orange" id="next_step" href="<?php echo site_url('installer/step_3') ?>">{retry}</a>
    <?php endif ?>
</section>

<script type="text/javascript">
    $(function () {
        $('#show-commands').click(function () {
            $(this).hide();
            $('#hide-commands').show();

            $('#commands').slideDown('slow');

            return false;
        });

        $('#hide-commands').click(function () {
            $(this).hide();
            $('#show-commands').show();

            $('#commands').slideUp('slow');

            return false;
        });
    });
</script>

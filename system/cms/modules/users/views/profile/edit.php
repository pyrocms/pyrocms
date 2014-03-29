<h2 id="page_title" class="page-title">
    <?php echo ($this->current_user->id !== $_user->id) ?
                    sprintf(lang('user:edit_title'), $_user->display_name) :
                    lang('user:profile_edit') ?>
</h2>
<div>
    <?php if (validation_errors()):?>
    <div class="error-box">
        <?php echo validation_errors();?>
    </div>
    <?php endif;?>

        <?php echo form_open_multipart('', 'class="streams_form"'); ?>

        <div class="form_inputs">

           <fieldset id="profile_fields">
            <ul>

            <?php foreach ($fields as $field) { ?>

                <li class="<?php  echo in_array(str_replace($stream->stream_slug.'-'.$stream->stream_namespace.'-', '', $field['input_slug']), $hidden) ? 'hidden' : null;  ?>">
                    <?php echo $field['input_row']; ?>
                </li>

            <?php } ?>

            </ul>
            </fieldset>

            <fieldset id="user_names">
                <legend><?php echo lang('global:email') ?></legend>
                <ul>
                    <li>
                        <label for="email"><?php echo lang('global:email') ?></label>
                        <div class="input">
                            <?php echo form_input('email', $_user->email) ?>
                        </div>
                    </li>
                </ul>
            </fieldset>

            <fieldset id="user_password">
                <legend><?php echo lang('user:password_section') ?></legend>
                <ul>
                    <li class="float-left spacer-right">
                        <label for="password"><?php echo lang('global:password') ?></label><br/>
                        <?php echo form_password('password', '', 'autocomplete="off"') ?>
                    </li>
                </ul>
            </fieldset>

            <?php if (Settings::get('api_enabled') and Settings::get('api_user_keys')): ?>

            <script>
            jQuery(function($) {

                $('input#generate_api_key').click(function(){

                    var url = "<?php echo site_url('api/ajax/generate_key') ?>",
                        $button = $(this);

                    $.post(url, function(data) {
                        $button.prop('disabled', true);
                        $('span#api_key').text(data.api_key).parent('li').show();
                    }, 'json');

                });

            });
            </script>

            <fieldset>
                <legend><?php echo lang('user:profile_api_section') ?></legend>

                <ul>
                    <li <?php $api_key or print('style="display:none"') ?>><?php echo sprintf(lang('api:key_message'), '<span id="api_key">'.$api_key.'</span>') ?></li>
                    <li>
                        <input type="button" id="generate_api_key" value="<?php echo lang('api:generate_key') ?>" />
                    </li>
                </ul>

            </fieldset>
            <?php endif ?>

        </div>
    
        <?php echo form_submit('', lang('user:profile_save_btn')) ?>
        <?php echo form_close() ?>

</div>

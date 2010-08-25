<h2><?php echo lang('user_password_reset_title')?></h2>

<?php if(!empty($error_string)):?>
<div class="error-box"><?php echo $error_string;?></div>
<?php endif;?>

<?php echo form_open('users/reset_complete', array('id'=>'reset_code')); ?>

<p class="float-left spacer-right">
    <label for="reset_code"><?php echo lang('user_activation_code'); ?></label><br/>
    <input type="text" name="reset_code" maxlength="40" value="<?php echo set_value('reset_code'); ?>" />  
</p>

<?php echo form_submit('submit_code', lang('user_reset_pass_btn')); ?>

<?php echo form_close();
<script type="text/javascript">
  var RecaptchaOptions = { 
    theme:"<?php echo $theme ?>",
    lang:"<?php echo $lang ?>"
  };
</script>
<script type="text/javascript" src="<?php echo $server ?>/challenge?k=<?php echo $key.$errorpart ?>"></script>
<noscript>
		<iframe src="<?php echo $server ?>/noscript?lang=<?php echo $lang ?>&k=<?php echo $key.$errorpart ?>" height="300" width="500" frameborder="0"></iframe><br/>
		<textarea name="recaptcha_challenge_field" rows="3" cols="40"></textarea>
		<input type="hidden" name="recaptcha" value="manual_challenge"/>
</noscript>
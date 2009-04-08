<?php
$lang->setModule("core");
$lang->setBlock("flash_prop");
?>
<script type="text/javascript" src="<?php echo SpawConfig::getStaticConfigValue('SPAW_DIR') ?>plugins/core/dialogs/flash_prop.js"></script>

<script type="text/javascript">
<!--
var spawErrorMessages = new Array();
<?php
echo 'spawErrorMessages["error_width_nan"] = "' . $lang->m('error_width_nan') . '";' . "\n";
echo 'spawErrorMessages["error_height_nan"] = "' . $lang->m('error_height_nan') . '";' . "\n";
?>
//-->
</script>
<table border="0" cellspacing="0" cellpadding="2" width="336">
<form name="img_prop" id="img_prop" onsubmit="return false;">
<tr>
  <td><?php echo $lang->m('source')?>:</td>
  <td colspan="3" nowrap><input type="text" name="csrc" id="csrc" class="input" size="32">&nbsp;<input type="button" value="..." onClick="SpawFlashPropDialog.browseClick()" class="bt"></td>
</tr>
<tr>
  <td><?php echo $lang->m('width')?>:</td>
  <td nowrap>
    <input type="text" name="cwidth" id="cwidth" size="3" maxlength="3" class="input3chars">
  </td>
  <td><?php echo $lang->m('height')?>:</td>
  <td nowrap>
    <input type="text" name="cheight" id="cheight" size="3" maxlength="3" class="input3chars">
  </td>
</tr>
<tr>
<td colspan="4" nowrap>
<hr width="100%">
</td>
</tr>
<tr>
<td colspan="4" align="right" valign="bottom" nowrap>
<input type="submit" value="<?php echo $lang->m('ok')?>" onClick="SpawFlashPropDialog.okClick()" class="bt">
<input type="button" value="<?php echo $lang->m('cancel')?>" onClick="SpawFlashPropDialog.cancelClick()" class="bt">
</td>
</tr>
</form>
</table>

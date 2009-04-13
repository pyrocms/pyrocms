<?php
$lang->setModule("core");
$lang->setBlock("image_prop");

$spaw_image_styles = $config->getConfigValue("image_styles");
?>
<script type="text/javascript" src="<?php echo SpawConfig::getStaticConfigValue('SPAW_DIR') ?>plugins/core/dialogs/image_prop.js"></script>

<script type="text/javascript">
<!--
var spawErrorMessages = new Array();
<?php
echo 'spawErrorMessages["error_width_nan"] = "' . $lang->m('error_width_nan') . '";' . "\n";
echo 'spawErrorMessages["error_height_nan"] = "' . $lang->m('error_height_nan') . '";' . "\n";
echo 'spawErrorMessages["error_border_nan"] = "' . $lang->m('error_border_nan') . '";' . "\n";
echo 'spawErrorMessages["error_hspace_nan"] = "' . $lang->m('error_hspace_nan') . '";' . "\n";
echo 'spawErrorMessages["error_vspace_nan"] = "' . $lang->m('error_vspace_nan') . '";' . "\n";
?>
//-->
</script>
<form name="img_prop" id="img_prop" onsubmit="return false;" style="padding: 0px; margin: 0px;">
<table border="0" cellspacing="0" cellpadding="2">
<tr>
  <td rowspan="9" id="img_preview_box" valign="top" align="center" class="groupbox" width="210">
    <div id="img_preview_placeholder" style="padding: 0px 1px 0px 0px; margin: 0px; visibility: hidden; white-space:nowrap;">
      <img id="img_preview_sizer" src="img/spacer.gif" width="1px" alt="" /><img id="img_preview" src="img/spacer.gif" width="200" height="100" alt="" />
    </div>
    <div id="img_data" class="info_message" style="visibility: hidden;">
      <b><?php echo $lang->m('dimensions')?>:</b><br />
      <span id="img_dimensions" class="info_message">&nbsp;</span><br />
      <a href="#" style="white-space: nowrap;" onclick="SpawImagePropDialog.resetDimensions();"><?php echo $lang->m('reset_dimensions')?> &raquo;</a>
    </div>
  </td>
  <td rowspan="9">&nbsp;</td>
  <td align="right" nowrap><?php echo $lang->m('source')?>:</td>
  <td colspan="3" nowrap><input type="text" name="csrc" id="csrc" class="input" size="32" onchange="SpawImagePropDialog.previewImage(this.value, 0);" />&nbsp;<input type="button" value="..." onClick="SpawImagePropDialog.imageBrowseClick()" class="bt"></td>
</tr>
<tr>
  <td align="right" nowrap><?php echo $lang->m('alt')?>:</td>
  <td colspan="3"><input type="text" name="calt" id="calt" class="input" size="32"></td>
</tr>
<tr>
  <td align="right" nowrap><?php echo $lang->m('title_attr')?>:</td>
  <td colspan="3"><input type="text" name="ctitle" id="ctitle" class="input" size="32"></td>
</tr>
<tr>
  <td align="right" nowrap><?php echo $lang->m('width')?>:</td>
  <td colspan="3" align="left" nowrap>
    <input type="text" name="cwidth" id="cwidth" size="4" maxlength="5" class="input3chars" onchange="SpawImagePropDialog.widthChanged();" />
  <?php echo $lang->m('height')?>:
    <input type="text" name="cheight" id="cheight" size="4" maxlength="5" class="input3chars" onchange="SpawImagePropDialog.heightChanged();" />
  </td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td colspan="3"><input type="checkbox" name="cproportions" id="cproportions" checked="yes" onclick="SpawImagePropDialog.proportionsClick();" /> <?php echo $lang->m('constrain_proportions')?></td>
</tr>
<tr>
  <td align="right" nowrap><?php echo $lang->m('css_class')?>:</td>
  <td nowrap colspan="3">
    <select id="ccssclass" name="ccssclass" id="ccssclass" size="1" class="input" onchange="SpawImagePropDialog.cssClassChanged();">
	<?php
	foreach($spaw_image_styles as $key => $text)
	{
		echo '<option value="'.$key.'">'.$text.'</option>'."\n";
	}
	?>
    </select>
  </td>
</tr>
<tr>
  <td align="right" nowrap><?php echo $lang->m('align')?>:</td>
  <td align="left" colspan="3">
  <select name="calign" id="calign" size="1" class="input">
    <option value=""></option>
    <option value="left"><?php echo $lang->m('left')?></option>
    <option value="right"><?php echo $lang->m('right')?></option>
    <option value="top"><?php echo $lang->m('top')?></option>
    <option value="middle"><?php echo $lang->m('middle')?></option>
    <option value="bottom"><?php echo $lang->m('bottom')?></option>
    <option value="absmiddle"><?php echo $lang->m('absmiddle')?></option>
    <option value="texttop"><?php echo $lang->m('texttop')?></option>
    <option value="baseline"><?php echo $lang->m('baseline')?></option>
  </select>
  </td>
</tr>
<tr>
  <td align="right" nowrap><?php echo $lang->m('border')?>:</td>
  <td align="left"><input type="text" name="cborder" id="cborder" class="input3chars"></td>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
</tr>
<tr>
  <td align="right" nowrap><?php echo $lang->m('hspace')?>:</td>
  <td colspan="3" nowrap>
    <input type="text" name="chspace" id="chspace" size="3" maxlength="3" class="input3chars">
    <?php echo $lang->m('vspace')?>:
    <input type="text" name="cvspace" id="cvspace" size="3" maxlength="3" class="input3chars">
  </td>
</tr>
</table>
<table border="0" cellspacing="0" cellpadding="2" width="100%">
<tr>
<td nowrap>
<hr width="100%">
</td>
</tr>
<tr>
<td align="right" valign="bottom" nowrap>
<input type="submit" value="<?php echo $lang->m('ok')?>" onClick="SpawImagePropDialog.okClick()" class="bt">
<input type="button" value="<?php echo $lang->m('cancel')?>" onClick="SpawImagePropDialog.cancelClick()" class="bt">
</td>
</tr>
</table>
</form>

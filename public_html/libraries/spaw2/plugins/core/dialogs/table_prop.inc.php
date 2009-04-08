<?php
$lang->setModule("core");
$lang->setBlock("table_prop");

$spaw_table_styles = $config->getConfigValue("table_styles");
?>
<script type="text/javascript" src="<?php echo SpawConfig::getStaticConfigValue('SPAW_DIR') ?>plugins/core/dialogs/table_prop.js"></script>

<script type="text/javascript">
<!--
var spawErrorMessages = new Array();
<?php
echo 'spawErrorMessages["error_rows_nan"] = "' . $lang->m('error_rows_nan') . '";' . "\n";
echo 'spawErrorMessages["error_columns_nan"] = "' . $lang->m('error_columns_nan') . '";' . "\n";
echo 'spawErrorMessages["error_width_nan"] = "' . $lang->m('error_width_nan') . '";' . "\n";
echo 'spawErrorMessages["error_height_nan"] = "' . $lang->m('error_height_nan') . '";' . "\n";
echo 'spawErrorMessages["error_border_nan"] = "' . $lang->m('error_border_nan') . '";' . "\n";
echo 'spawErrorMessages["error_cellpadding_nan"] = "' . $lang->m('error_cellpadding_nan') . '";' . "\n";
echo 'spawErrorMessages["error_cellspacing_nan"] = "' . $lang->m('error_cellspacing_nan') . '";' . "\n";
?>
//-->
</script>

<table border="0" cellspacing="0" cellpadding="2" width="336">
<form name="table_prop" id="table_prop" onsubmit="return false;">
<tr>
  <td><?php echo $lang->m('rows')?>:</td>
  <td><input type="text" name="trows" id="trows" size="3" maxlength="3" class="input3chars"></td>
  <td><?php echo $lang->m('columns')?>:</td>
  <td><input type="text" name="tcols" id="tcols" size="3" maxlenght="3" class="input3chars"></td>
</tr>
<tr>
  <td><?php echo $lang->m('css_class')?>:</td>
  <td colspan="3">
    <select id="tcssclass" name="tcssclass" size="1" class="input" onchange="SpawTablePropDialog.cssClassChanged();">
	<?php
	foreach($spaw_table_styles as $key => $text)
	{
		echo '<option value="'.$key.'">'.$text.'</option>'."\n";
	}
	?>
    </select>
  </td>
</tr>
<tr>
  <td><?php echo $lang->m('width')?>:</td>
  <td nowrap>
    <input type="text" name="twidth" id="twidth" size="3" maxlenght="3" class="input3chars">
    <select size="1" name="twunits" id="twunits" class="input">
      <option value="%">%</option>
      <option value="px">px</option>
    </select>
  </td>
  <td><?php echo $lang->m('height')?>:</td>
  <td nowrap>
    <input type="text" name="theight" id="theight" size="3" maxlenght="3" class="input3chars">
    <select size="1" name="thunits" id="thunits" class="input">
      <option value="%">%</option>
      <option value="px">px</option>
    </select>
  </td>
</tr>
<tr>
  <td><?php echo $lang->m('border')?>:</td>
  <td colspan="3"><input type="text" name="tborder" id="tborder" size="2" maxlenght="2" class="input3chars"> <?php echo $lang->m('pixels')?></td>
</tr>
<tr>
  <td><?php echo $lang->m('cellpadding')?>:</td>
  <td><input type="text" name="tcpad" id="tcpad" size="3" maxlenght="3" class="input3chars"></td>
  <td><?php echo $lang->m('cellspacing')?>:</td>
  <td><input type="text" name="tcspc" id="tcspc" size="3" maxlenght="3" class="input3chars"></td>
</tr>
<tr>
  <td colspan="4"><?php echo $lang->m('bg_color')?>: <img src="img/spacer.gif" id="color_sample" border="1" width="30" height="18" align="absmiddle">&nbsp;<input type="text" name="tbgcolor" id="tbgcolor" size="7" maxlenght="7" class="input7chars" onKeyUp="setSample()" align="absmiddle">
  <input type="button" id="tcolorpicker" border="0" onClick="SpawTablePropDialog.showColorPicker(tbgcolor.value)" align="absbottom" value="..." class="bt" align="absmiddle">
  </td>
</tr>
<tr>
  <td colspan="4">
	<?php echo $lang->m('background')?>: <input type="text" name="tbackground" id="tbackground" size="20" class="input" >&nbsp;<input type="button" id="timg_picker" onClick="SpawTablePropDialog.showImgPicker();" value="..." class="bt" align="absmiddle">	
  </td>
</tr>
<tr>
<td colspan="4" nowrap>
<hr width="100%">
</td>
</tr>
<tr>
<td colspan="4" align="right" valign="bottom" nowrap>
<input type="submit" value="<?php echo $lang->m('ok')?>" onClick="SpawTablePropDialog.okClick()" class="bt">
<input type="button" value="<?php echo $lang->m('cancel')?>" onClick="SpawTablePropDialog.cancelClick()" class="bt">
</td>
</tr>
</form>
</table>

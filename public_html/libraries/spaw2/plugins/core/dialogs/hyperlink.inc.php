<?php
$lang->setModule("core");
$lang->setBlock("hyperlink");

$spaw_a_targets = $config->getConfigValue("a_targets");
$spaw_quick_links = $config->getConfigValue("quick_links");
?>
<script type="text/javascript" src="<?php echo SpawConfig::getStaticConfigValue('SPAW_DIR') ?>plugins/core/dialogs/hyperlink.js"></script>

<form name="a_prop" onsubmit="return false;">
<table border="0" cellpadding="0" cellspacing="0" id="prop_table">
<tr>
<td valign="top" align="left">
<table border="0" cellpadding="2" cellspacing="0">
<tr>
  <td width="50%"><?php echo $lang->m('a_type')?>:</td>
  <td width="50%">
  <select name="catype" id="catype" size="1" class="input" onchange="SpawHyperlinkDialog.changeType(this.options[this.selectedIndex].value);">
  	<option value="link"><?php echo $lang->m('type_link')?></option>
  	<option value="anchor"><?php echo $lang->m('type_anchor')?></option>
  	<option value="link2anchor"><?php echo $lang->m('type_link2anchor')?></option>
  </select>
  </td>
</tr>
<tr id="url_row">
  <td width="50%"><?php echo $lang->m('url')?>:</td>
  <td width="50%" nowrap><input type="text" name="chref" id="chref" class="input" size="32">&nbsp;<input type="button" value="..." onClick="SpawHyperlinkDialog.browseClick()" class="bt"></td>
</tr>
<?php 
if (is_array($spaw_quick_links) && count($spaw_quick_links)>0) 
{ 
?>
<tr id="quick_link_row">
  <td width="50%"><?php echo $lang->m('quick_links')?>:</td>
  <td width="50%" align="left">
  <select name="cquicklinks" id="cquicklinks" size="1" class="input" onchange="SpawHyperlinkDialog.changeQuickLink(this.options[this.selectedIndex].value);" style="width: 50px;">
    <option value=""></option>
    <?php
		foreach($spaw_quick_links as $key=>$value)
		{
			echo '<option value="'.$key.'">'.$value."</option>";
		}
	?>
  </select>
  </td>
</tr>
<?php 
} 
?>
<tr id="name_row">
  <td width="50%"><?php echo $lang->m('name')?>:</td>
  <td width="50%"><input type="text" name="cname" id="cname" class="input" size="32"></td>
</tr>
<tr id="anchor_row">
  <td width="50%"><?php echo $lang->m('anchors')?>:</td>
  <td width="50%">
  <select name="canchor" id="canchor" size="1" class="input">
  	<option></option>
  </select>
  </td>
</tr>
<tr id="target_row">
  <td width="50%"><?php echo $lang->m('target')?>:</td>
  <td width="50%" align="left">
  <select name="ctarget" id="ctarget" size="1" class="input">
    <?php
		foreach($spaw_a_targets as $key=>$value)
		{
			if ($lang->m($key,'hyperlink_targets')!='') 
				$value = $lang->m($key,'hyperlink_targets');
			echo '<option value="'.$key.'">'.$value."</option>";
		}
	?>
  </select>
  </td>
</tr>
<tr id="title_row">
  <td width="50%"><?php echo $lang->m('title_attr')?>:</td>
  <td width="50%" align="left">
    <input type="text" name="ctitle" id="ctitle" size="32" class="input">
  </td>
</tr>
</table>
</td>
</tr>
</table>
<table border="0" cellpadding="2" cellspacing="0" width="100%">
<tr>
<td nowrap>
<hr width="100%">
</td>
</tr>
<tr>
<td align="right" valign="bottom" nowrap>
<input type="submit" value="<?php echo $lang->m('ok')?>" onClick="SpawHyperlinkDialog.okClick()" class="bt">
<input type="button" value="<?php echo $lang->m('cancel')?>" onClick="SpawHyperlinkDialog.cancelClick()" class="bt">
</td>
</tr>
</table>

</form>

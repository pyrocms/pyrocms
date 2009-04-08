<script type="text/javascript" src="<?php echo SpawConfig::getStaticConfigValue('SPAW_DIR') ?>plugins/core/dialogs/colorpicker.js"></script>
<form onsubmit="return false;" style="padding: 0px; margin:0px;">
<table border="0" cellpadding="0" cellspacing="0">
<tr>
<td align="left" valign="top">
  <div class="groupbox">
    <table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td style="vertical-align: middle; padding: 5px 5px 5px 5px;">
        <img id="hs_marker" src="<?php echo SpawConfig::getStaticConfigValue('SPAW_DIR') ?>plugins/core/dialogs/img/crosshair.gif" border="0" style="width: 9px; height: 9px; z-index: 50; position: absolute; left: 100; top: 100; visibility: hidden; cursor: crosshair;" unselectable="on" />
        <img id="hs_grid" src="<?php echo SpawConfig::getStaticConfigValue('SPAW_DIR') ?>plugins/core/dialogs/img/huesaturation.jpg" border="0" style="border: 1px solid black; width: 180px; height: 202px; cursor: crosshair;" onclick="SpawColorPicker.hsClick(event, this);" /></td>
      <td id="brightness_control_placeholder" style="vertical-align: middle; padding: 5px 5px 5px 5px; width: 25px;">&nbsp;</td>
      <td style="vertical-align: middle; padding: 0px 5px 0px 5px; width: 25px;">&nbsp;
        <img id="b_marker" src="<?php echo SpawConfig::getStaticConfigValue('SPAW_DIR') ?>plugins/core/dialogs/img/leftarrow.gif" border="0" style="width: 8px; height: 9px; z-index: 50; position: absolute; left: 100; top: 100; visibility: hidden;" unselectable="on" />
      </td>
    </tr>
    </table>
  </div>
</td>
<td align="left" valign="top" rowspan="2">
  <div class="groupbox">
    <fieldset itle="HSB">
    <legend>HSB</legend>
    <div align="right">
    <table border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td algin="left" valign="middle">H:</td>
        <td algin="left" valign="middle"><input type="text" name="iHue" id="iHue" class="input3chars" maxlength="3" onkeyup="SpawColorPicker.inputKeyUp(event, 'h', this);" onchange="SpawColorPicker.setCurrentColor(SpawColorPicker.getCurrentColor());" /></td>
      </tr>
      <tr>
        <td algin="left" valign="middle">S:</td>
        <td algin="left" valign="middle"><input type="text" name="iSaturation" id="iSaturation" class="input3chars" maxlength="3" onkeyup="SpawColorPicker.inputKeyUp(event, 's', this);" onchange="SpawColorPicker.setCurrentColor(SpawColorPicker.getCurrentColor());" /></td>
      </tr>
      <tr>
        <td algin="left" valign="middle">B:</td>
        <td algin="left" valign="middle"><input type="text" name="iBrightness" id="iBrightness" class="input3chars" maxlength="3" onkeyup="SpawColorPicker.inputKeyUp(event, 'v', this);" onchange="SpawColorPicker.setCurrentColor(SpawColorPicker.getCurrentColor());" /></td>
      </tr>
    </table>
    </div>
    </fieldset>

    <fieldset itle="RGB">
    <legend>RGB</legend>
    <div align="right">
    <table border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td algin="left" valign="middle">R:</td>
        <td algin="left" valign="middle"><input type="text" name="iRed" id="iRed" class="input3chars" maxlength="3" onkeyup="SpawColorPicker.inputKeyUp(event, 'r', this);" onchange="SpawColorPicker.setCurrentColor(SpawColorPicker.getCurrentColor());" /></td>
      </tr>
      <tr>
        <td algin="left" valign="middle">G:</td>
        <td algin="left" valign="middle"><input type="text" name="iGreen" id="iGreen" class="input3chars" maxlength="3" onkeyup="SpawColorPicker.inputKeyUp(event, 'g', this);" onchange="SpawColorPicker.setCurrentColor(SpawColorPicker.getCurrentColor());" /></td>
      </tr>
      <tr>
        <td algin="left" valign="middle">B:</td>
        <td algin="left" valign="middle"><input type="text" name="iBlue" id="iBlue" class="input3chars" maxlength="3" onkeyup="SpawColorPicker.inputKeyUp(event, 'b', this);" onchange="SpawColorPicker.setCurrentColor(SpawColorPicker.getCurrentColor());" /></td>
      </tr>
    </table>
    </div>
    </fieldset>

    <fieldset title="HTML">
    <legend>HTML</legend>
    <table border="0" cellpadding="2" cellspacing="0">
      <tr>
        <td algin="left" valign="middle"><input type="text" name="iHex" id="iHex" class="input7chars" onkeyup="SpawColorPicker.inputKeyUp(event, 'x', this);" onchange="SpawColorPicker.setCurrentColor(SpawColorPicker.getCurrentColor());" /></td>
      </tr>
    </table>
    </fieldset>

  </div>
</td>
</tr>
<tr>
  <td>
    <div class="groupbox">
      <style type="text/css">
      <!--
      .spawCPpredefColor
      {
        border: 1px solid black;
        width: 20px; height: 20px;
      }
      -->
      </style>
      <?php
      $predef_colors = $config->getConfigValue('colorpicker_predefined_colors');
      ?>
      <table border="0" cellpadding="0" cellspacing="3">
      <tr>
        <td rowspan="2" id="color_sample" style="width: 40px; border: 1px solid black;">&nbsp;</td>
        <td class="spawCPpredefColor" style="background: <?php echo (empty($predef_colors[0])?'black':$predef_colors[0])?>; cursor: pointer;" onclick="SpawColorPicker.setCurrentColorFromHTML(this.style.backgroundColor, this);">&nbsp;</td>
        <td class="spawCPpredefColor" style="background: <?php echo (empty($predef_colors[1])?'silver':$predef_colors[1])?>; cursor: pointer;" onclick="SpawColorPicker.setCurrentColorFromHTML(this.style.backgroundColor, this);">&nbsp;</td>
        <td class="spawCPpredefColor" style="background: <?php echo (empty($predef_colors[2])?'gray':$predef_colors[2])?>; cursor: pointer;" onclick="SpawColorPicker.setCurrentColorFromHTML(this.style.backgroundColor, this);">&nbsp;</td>
        <td class="spawCPpredefColor" style="background: <?php echo (empty($predef_colors[3])?'white':$predef_colors[3])?>; cursor: pointer;" onclick="SpawColorPicker.setCurrentColorFromHTML(this.style.backgroundColor, this);">&nbsp;</td>
        <td class="spawCPpredefColor" style="background: <?php echo (empty($predef_colors[4])?'maroon':$predef_colors[4])?>; cursor: pointer;" onclick="SpawColorPicker.setCurrentColorFromHTML(this.style.backgroundColor, this);">&nbsp;</td>
        <td class="spawCPpredefColor" style="background: <?php echo (empty($predef_colors[5])?'red':$predef_colors[5])?>; cursor: pointer;" onclick="SpawColorPicker.setCurrentColorFromHTML(this.style.backgroundColor, this);">&nbsp;</td>
        <td class="spawCPpredefColor" style="background: <?php echo (empty($predef_colors[6])?'purple':$predef_colors[6])?>; cursor: pointer;" onclick="SpawColorPicker.setCurrentColorFromHTML(this.style.backgroundColor, this);">&nbsp;</td>
        <td class="spawCPpredefColor" style="background: <?php echo (empty($predef_colors[7])?'fuchsia':$predef_colors[7])?>; cursor: pointer;" onclick="SpawColorPicker.setCurrentColorFromHTML(this.style.backgroundColor, this);">&nbsp;</td>
      </tr>
      <tr>
        <td class="spawCPpredefColor" style="background: <?php echo (empty($predef_colors[8])?'green':$predef_colors[8])?>; cursor: pointer;" onclick="SpawColorPicker.setCurrentColorFromHTML(this.style.backgroundColor, this);">&nbsp;</td>
        <td class="spawCPpredefColor" style="background: <?php echo (empty($predef_colors[9])?'lime':$predef_colors[9])?>; cursor: pointer;" onclick="SpawColorPicker.setCurrentColorFromHTML(this.style.backgroundColor, this);">&nbsp;</td>
        <td class="spawCPpredefColor" style="background: <?php echo (empty($predef_colors[10])?'olive':$predef_colors[10])?>; cursor: pointer;" onclick="SpawColorPicker.setCurrentColorFromHTML(this.style.backgroundColor, this);">&nbsp;</td>
        <td class="spawCPpredefColor" style="background: <?php echo (empty($predef_colors[11])?'yellow':$predef_colors[11])?>; cursor: pointer;" onclick="SpawColorPicker.setCurrentColorFromHTML(this.style.backgroundColor, this);">&nbsp;</td>
        <td class="spawCPpredefColor" style="background: <?php echo (empty($predef_colors[12])?'navy':$predef_colors[12])?>; cursor: pointer;" onclick="SpawColorPicker.setCurrentColorFromHTML(this.style.backgroundColor, this);">&nbsp;</td>
        <td class="spawCPpredefColor" style="background: <?php echo (empty($predef_colors[13])?'blue':$predef_colors[13])?>; cursor: pointer;" onclick="SpawColorPicker.setCurrentColorFromHTML(this.style.backgroundColor, this);">&nbsp;</td>
        <td class="spawCPpredefColor" style="background: <?php echo (empty($predef_colors[14])?'teal':$predef_colors[14])?>; cursor: pointer;" onclick="SpawColorPicker.setCurrentColorFromHTML(this.style.backgroundColor, this);">&nbsp;</td>
        <td class="spawCPpredefColor" style="background: <?php echo (empty($predef_colors[15])?'aqua':$predef_colors[15])?>; cursor: pointer;" onclick="SpawColorPicker.setCurrentColorFromHTML(this.style.backgroundColor, this);">&nbsp;</td>
      </tr>
      </table>
    </div>
  </td>
</tr>
</table>

<div class="buttonbox">
<input type="submit" class="bt" value="<?php echo $lang->m('ok', 'colorpicker', 'core') ?>" onclick="SpawColorPicker.okClick();" />&nbsp;<input type="button" class="bt" value="<?php echo $lang->m('cancel', 'colorpicker', 'core') ?>" onclick="SpawColorPicker.cancelClick();" />
</div>
</form>
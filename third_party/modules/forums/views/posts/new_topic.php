{$template.partials.breadcrumbs}
<?=form_open('forums/topics/new_topic/'.$forum->id);?>

<? if( !empty($validation_errors) ): ?>
<table width="100%" border="0" cellpadding="4" cellspacing="0">
  <tr>
    <td width="85%" bgcolor="#FF0000"><font color="#FFFFFF"><b><?php echo $validation_errors;?></b></font></td>
  </tr>
</table>
<br />
<?php endif; ?>

<? if($show_preview): ?>
<table width="100%" border="0" cellpadding="4" cellspacing="0">
  <tr>
    <th align="left" bgcolor="#999999" scope="col">Preview</th>
  </tr>
  <tr>
    <td width="85%" bgcolor="#CCCCCC"><?=parse_bbcode(set_value('text'));?></td>
  </tr>
</table>
<br />
<? endif; ?>

<table width="100%" border="0" cellpadding="4" cellspacing="0">
  <tr>
    <th colspan="2" align="left" bgcolor="#999999" scope="col"> Post a New Topic to <?php echo $forum->title;?></th>
  </tr>
  <tr>
    <td width="15%" valign="top" bgcolor="#CCCCCC"><b>Title:</b></td>
    <td width="85%" bgcolor="#CCCCCC"><input type="text" class="input" name="title" style='width:100%' size="90" value="<?php echo set_value('title');?>" /></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#CCCCCC"><hr /></td>
  </tr> 
  <tr>
    <td width="15%" bgcolor="#CCCCCC"><b>Formatting:</b></td>
    <td width="85%" bgcolor="#CCCCCC"><?//=bbcode_menu();?></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#CCCCCC"><hr /></td>
  </tr>  
  <tr>
    <td width="15%" valign="top" bgcolor="#CCCCCC"><b>Message:</b></td>
    <td width="85%" bgcolor="#CCCCCC"><textarea name="text" rows="15" cols="70"><?php echo set_value('text');?></textarea></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#CCCCCC"><hr></td>
  </tr>  
  <tr>
    <td  width="15%" valign="top" bgcolor="#CCCCCC"><b>Options:</b></td>
    <td width="85%" bgcolor="#CCCCCC">
		<?php echo form_checkbox('notify', 1, set_value('notify') == 1 | empty($_POST)); ?> <label for="notify">Notify me via email when someone posts in this thread.</label>
	</td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#CCCCCC"><hr /></td>
  </tr>
  <tr>
    <td colspan="2" align="center" bgcolor="#CCCCCC"><input type="submit" name="preview" value="Preview Topic" /> | <input type="submit" name="submit" class="submit" value="Submit Topic" /></td>
  </tr>  
</table>

<?php echo form_close(); ?>
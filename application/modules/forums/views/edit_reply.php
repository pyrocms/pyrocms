<?=form_open_multipart('forums/posts/edit_reply/'.$topicID, array('id'=>'submit_post', 'name'=>'submit_post'));?>
<?=form_hidden('postID', $postID);?>

<? if(!empty($error_msg)): ?>
<table width="100%" border="0" cellpadding="4" cellspacing="0">
  <tr>
    <td width="85%" bgcolor="#FF0000"><font color="#FFFFFF"><b><?=$error_msg;?></b></font></td>
  </tr>
</table>
<br />
<? elseif(!empty($preview)): ?>
<table width="100%" border="0" cellpadding="4" cellspacing="0">
  <tr>
    <th align="left" bgcolor="#999999" scope="col"> Preview</th>
  </tr>
  <tr>
    <td width="85%" bgcolor="#CCCCCC"><?=$preview;?></td>
  </tr>
</table>
<br />
<? endif; ?>
<table width="100%" border="0" cellpadding="4" cellspacing="0">
  <tr>
    <th colspan="2" align="left" bgcolor="#999999" scope="col"> Edit a Reply in <?=$topic_name;?></th>
  </tr>
  <tr>
    <td width="15%" bgcolor="#CCCCCC"><b>Formatting:</b></td>
    <td width="85%" bgcolor="#CCCCCC"><?=bbcode_menu();?></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#CCCCCC"><hr></td>
  </tr>  
  <tr>
    <td width="15%" valign="top" bgcolor="#CCCCCC"><b>Message:</b></td>
    <td width="85%" bgcolor="#CCCCCC"><textarea name="message" rows="15" cols="70"><?=$message;?></textarea></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#CCCCCC"><hr></td>
  </tr>  
  <tr>
    <td width="15%" bgcolor="#CCCCCC"><b>Options:</b></td>
    <td width="85%" bgcolor="#CCCCCC">ops. go here</td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#CCCCCC"><hr></td>
  </tr>
  <tr>
    <td colspan="2" align="center" bgcolor="#CCCCCC"><input type="submit" name="preview" value="Preview Post" /> | <input type="submit" name="submit" class="submit" value="Submit Post" /></td>
  </tr>  
</table>
</form>
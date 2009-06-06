<?=form_open('forums/posts/report/'.$topicID, array('id'=>'submit_post', 'name'=>'submit_post'));?>

<? if(!empty($error_msg)) { ?>
<table width="100%" border="0" cellpadding="4" cellspacing="0">
  <tr>
    <td width="85%" bgcolor="#FF0000"><font color="#FFFFFF"><b><?=$error_msg;?></b></font></td>
  </tr>
</table>
<br />
<? } ?>
<table width="100%" border="0" cellpadding="4" cellspacing="0">
  <tr>
    <th colspan="2" align="left" bgcolor="#999999" scope="col">Report to Moderator</th>
  </tr>
  <tr>
    <td width="15%" bgcolor="#CCCCCC"><b>Topic Name:</b></td>
    <td width="85%" bgcolor="#CCCCCC"><?=$topic_name;?></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#CCCCCC"><hr></td>
  </tr>  
  <tr>
    <td width="15%" valign="top" bgcolor="#CCCCCC"><b>Report Text:</b></td>
    <td width="85%" bgcolor="#CCCCCC"><textarea name="message" rows="10" cols="70"><?=$message;?></textarea></td>
  </tr>
  <tr>
    <td colspan="2" bgcolor="#CCCCCC"><hr></td>
  </tr>
  <tr>
    <td colspan="2" align="center" bgcolor="#CCCCCC"><input type="submit" name="submit" class="submit" value="Submit Report" /></td>
  </tr>  
</table>
</form>
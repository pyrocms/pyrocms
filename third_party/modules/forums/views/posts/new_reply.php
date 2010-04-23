{$template.partials.breadcrumbs}
<?=form_open('forums/posts/new_reply/'.$topic->id);?>

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
    <th align="left" bgcolor="#999999" scope="col"> Preview</th>
  </tr>
  <tr>
    <td width="85%" bgcolor="#CCCCCC"><?=parse_bbcode(set_value('text'));?></td>
  </tr>
</table>
<br />
<? endif; ?>

<table width="100%" border="0" cellpadding="4" cellspacing="0">
  <tr>
    <th colspan="2" align="left" bgcolor="#999999" scope="col"> Post a new reply to "<?php echo $topic->title;?>" in <?php echo $forum->title;?></th>
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
    <td width="85%" bgcolor="#CCCCCC">
    	<?php if(!empty($quote)): ?>
    		<?php echo form_textarea('text', sprintf('[quote date=%s author=%s]%s[/quote]', $quote->created_on, $quote->author_id, $quote->content));?>
    	<?php else: ?>
    		<?php echo form_textarea('text', set_value('text'));?>
    	<?php endif; ?>
    </td>
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
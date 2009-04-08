<?= form_open('admin/themes/delete');?>

<table border="0" class="listTable">

  <thead>
	<tr>
		<th class="first"><div></div></th>
		<th><a href="#">Theme</a></th>
		<th class="last"><span>Actions</span></th>
	</tr>
  </thead>
  
	<tbody>
	
<? if (!empty($themes)) {
		foreach ($themes as $theme) {
			echo '<tr>
					<td align="center"><input type="checkbox" name="action_to[' . $theme->name . ']" /></td>
					<td>' . $theme->name . '</td>
					<td>';
			if($this->settings->item('default_theme') != $theme->name) 
				echo anchor('admin/themes/setdefault/' . $theme->name, 'Make Default') . ' | ' . anchor('admin/themes/delete/' . $theme->name, 'Delete', array('class'=>'confirm'));
			else 
				echo '<i>Default Theme</i>';
			echo '	</td>
				  </tr>';
		}
} else {
	echo '<tr><td colspan="3">There are no themes installed.</td></tr>';
}
?>
	</tbody>
</table>

<p>
    <input type="image" name="btnDelete" value="Delete" src="/assets/img/admin/fcc/btn-delete.jpg" />
     or 
	<?= anchor('admin', 'Cancel'); ?>
</p>

<?=form_close(); ?>
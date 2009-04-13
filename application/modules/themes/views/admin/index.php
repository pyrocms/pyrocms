<?= form_open('admin/themes/delete');?>

<table border="0" class="listTable">

  <thead>
	<tr>
		<th class="first"><div></div></th>
		<th><a href="#">Theme</a></th>
		<th class="last width-quater"><span>Actions</span></th>
	</tr>
  </thead>
  <tfoot>
  	<tr>
  		<td colspan="3">
  			<div class="inner"></div>
  		</td>
  	</tr>
  </tfoot>
  
	<tbody>
	
<? if (!empty($themes)) {
		foreach ($themes as $theme) {
			echo '<tr>
					<td align="center"><input type="checkbox" name="delete[]" value="' . $theme->name . '" /></td>
					<td>' . $theme->name . '</td>
					<td>';
			if($this->settings->item('default_theme') != $theme->name) 
				echo anchor('admin/themes/setdefault/' . $theme->slug, 'Make Default') . ' | ' . anchor('admin/themes/delete/' . $theme->slug, 'Delete', array('class'=>'confirm'));
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


<? $this->load->view('admin/layout_fragments/table_buttons', array('buttons' => array('delete') )); ?>

<?=form_close(); ?>
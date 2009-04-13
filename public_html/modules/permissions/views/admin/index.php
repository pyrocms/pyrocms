<script type="text/javascript">
	jQuery(document).ready(function(){ 
		jQuery('a.delete_role').click(function(){
			return confirm('Are you sure you would like to delete this permission role? This will delete ALL navigation links within the role, and the layout files will need to be edited to remove refference to it.');
		});
	});
</script>

<?= form_open('admin/permissions/delete');?>

<p class="float-right">[ <?=anchor('admin/permissions/roles/create', 'Add a role') ?> ]</p>

<br class="clear-both" />

<? if (!empty($roles)):
	
	foreach ($roles as $role): ?>
	
		<h3 class="float-left"><?=$role->title; ?></h3>
	
		<p class="float-right">
			[ <?=anchor('admin/permissions/roles/edit/'.$role->id, 'Edit') ?> | 
			  <?=anchor('admin/permissions/roles/delete/'.$role->id, 'Delete', 'class="delete_role"') ?> ]
		</p>
		
		<table border="0" class="listTable spacer-bottom">
		  
		  <thead>
			<tr>
				<th class="first"><div></div></th>
				<th><a href="#">Module</a></th>
				<th><a href="#">Controller</a></th>
				<th><a href="#">Method</a></th>
				<th class="last width-10"><span>Actions</span></th>
			</tr>
		  </thead>
		  <tfoot>
		  	<tr>
		  		<td colspan="5">
		  			<div class="inner"></div>
		  		</td>
		  	</tr>
		  </tfoot>

		<tbody>
		<? if (!empty($rules[$role->abbrev])):
		
			foreach ($rules[$role->abbrev] as $navigation_link): ?>
				<tr>
					<td><input type="checkbox" name="delete[<?=$navigation_link->id;?>]" /></td>
                    <td><?=$navigation_link->module;?></td>
                    <td><?=$navigation_link->controller; ?></td>
                    <td><?=$navigation_link->method;?></td>
                    <td><?= anchor('admin/permissions/edit/' . $navigation_link->id, 'Edit') . ' | '
                          . anchor('admin/permissions/delete/' . $navigation_link->id, 'Delete', array('class'=>'confirm'));?></td>
				</tr>
			<? endforeach; ?>
		
		<? else:?>
			<tr><td colspan="5">There are no rules for this role.</td></tr>
		<? endif; ?>
		
		</tbody>
	</table>
	
	<br/>
	
	<? endforeach; ?>
	
<? else: ?>
	<p>There are no roles. Add a type called Administrator with the abbreviation of admin ASAP.</p>
	
<? endif; ?>

<? $this->load->view('admin/layout_fragments/table_buttons', array('buttons' => array('delete') )); ?>

<?=form_close(); ?>
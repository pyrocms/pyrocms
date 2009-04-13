<?= form_open('admin/navigation/delete');?>

<p class="float-right">[ <?=anchor('admin/navigation/groups/create', 'Add a group') ?> ]</p>

<br class="clear-both" />

<div class="message message-notice">
	<h6>Note</h6>
	<p>
		Currently naviation groups are referenced in the layout files and cannot be 
		changed dynamically. You may add and delete them, but you will need to dive into the source-code
	 	to get the new group put into your site.
	</p>
	<a class="close icon icon_close tooltip" href="#"></a>
</div>

<br class="clear-both" />

<? if (!empty($groups)):
	
	foreach ($groups as $group): ?>
	
		<h3 class="float-left"><?=$group->title; ?></h3>
	
		<p class="float-right">[ <?=anchor('admin/navigation/groups/delete/'.$group->id, 'Delete group "'.$group->title.'"', 'class="delete_group"') ?> ]</p>
		
		<table border="0" class="listTable clear-both">
		    
		  <thead>
			<tr>
				<th class="first"><div></div></th>
				<th class="width-10"><a href="#">Title</a></th>
				<th class="width-5"><a href="#">Position</a></th>
				<th class="width-20"><a href="#">URL</a></th>
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
		<? if (!empty($navigation[$group->abbrev])):
		
			foreach ($navigation[$group->abbrev] as $navigation_link): ?>
				<tr>
					<td><input type="checkbox" name="delete[<?=$navigation_link->id;?>]" /></td>
                    <td><?=$navigation_link->title;?></td>
                    <td><?=$navigation_link->position; ?></td>
                    <td><?= anchor($navigation_link->url, $navigation_link->url, 'target="_blank"');?></td>
                    <td><?= anchor('admin/navigation/edit/' . $navigation_link->id, 'Edit') . ' | '
                          . anchor('admin/navigation/delete/' . $navigation_link->id, 'Delete', array('class'=>'confirm'));?></td>
				</tr>
			<? endforeach; ?>
		
		<? else:?>
			<tr><td colspan="5">There are no links in this group.</td></tr>
		<? endif; ?>
		
		</tbody>
	</table>
	
	<br/>
	
	<? endforeach; ?>
	
<? else: ?>
	<p>There are no navigation groups.</p>
<? endif; ?>

<? $this->load->view('admin/layout_fragments/table_buttons', array('buttons' => array('delete') )); ?>

<?=form_close(); ?>


<script type="text/javascript">
	$(document).ready(function(){ 
		$('a.delete_group').click(function(){
			return confirm('Are you sure you would like to delete this navigation group? This will delete ALL navigation links within the group, and the layout files will need to be edited to remove refference to it.');
		});
	});
</script>
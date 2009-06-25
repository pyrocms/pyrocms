<?= form_open('admin/permissions/delete');?>
<p class="float-right">[ <?=anchor('admin/permissions/roles/create', lang('perm_role_add')) ?> ]</p>
<br class="clear-both" />

<? if (!empty($roles)): ?>	
	<? foreach ($roles as $role): ?>
		<h3 class="float-left"><?=$role->title; ?></h3>	
		<p class="float-right">
			[ <?=anchor('admin/permissions/roles/edit/'.$role->id, lang('perm_role_edit')); ?> | 
			  <?=anchor('admin/permissions/roles/delete/'.$role->id, lang('perm_role_delete'), 'class="delete_role"'); ?> ]
		</p>		
		<table border="0" class="listTable spacer-bottom">		  
		  <thead>
				<tr>
					<th class="first"><div></div></th>
					<th><a href="#"><?= lang('perm_module_label');?></a></th>
					<th><a href="#"><?= lang('perm_controller_label');?></a></th>
					<th><a href="#"><?= lang('perm_method_label');?></a></th>
					<th class="last width-10"><span><?= lang('perm_action_label');?></span></th>
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
			<? if (!empty($rules[$role->abbrev])): ?>			
				<? foreach ($rules[$role->abbrev] as $navigation_link): ?>
					<tr>
						<td><input type="checkbox" name="delete[<?=$navigation_link->id;?>]" /></td>
						<td><?=$navigation_link->module;?></td>
						<td><?=$navigation_link->controller; ?></td>
						<td><?=$navigation_link->method;?></td>
						<td>
							<?= anchor('admin/permissions/edit/' . $navigation_link->id, lang('perm_rule_edit')) . ' | '; ?>
							<?= anchor('admin/permissions/delete/' . $navigation_link->id, lang('perm_rule_delete'), array('class'=>'confirm'));?>
						</td>
					</tr>
				<? endforeach; ?>			
			<? else:?>
				<tr>
					<td colspan="5"><?= lang('perm_role_no_rules');?></td>
				</tr>
			<? endif; ?>			
			</tbody>
	</table>	
	<br/>	
	<? endforeach; ?>	
<? else: ?>
	<p><?= lang('perm_no_roles');?></p>	
<? endif; ?>
<? $this->load->view('admin/fragments/table_buttons', array('buttons' => array('delete') )); ?>
<?=form_close(); ?>
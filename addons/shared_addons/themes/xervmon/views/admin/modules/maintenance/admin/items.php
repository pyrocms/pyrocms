 
<div class="accordion-group ">
<div class="accordion-heading">
		<h4><?php echo lang('maintenance:export_data') ?></h4>
	</div>
	
	<div class="accordion-body collapse in lst">
		<div class="content">
	
			<?php if ( ! empty($tables)): ?>
				  <table class="table table-striped" cellspacing="0">
					<thead>
						<tr>
							<th><?php echo lang('maintenance:table_label') ?></th>
							<th class="align-center"><?php echo lang('maintenance:record_label') ?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($tables as $table): ?>
						<tr>
							<td><?php echo $table['name'] ?></td>
							<td class="align-center"><?php echo $table['count'] ?></td>
							<td class="buttons buttons-small align-center actions">
								<?php if ($table['count'] > 0):
									echo anchor('admin/maintenance/export/'.$table['name'].'/xml', lang('maintenance:export_xml'), array('class'=>'button btn')).' ';
									echo anchor('admin/maintenance/export/'.$table['name'].'/csv', lang('maintenance:export_csv'), array('class'=>'button btn')).' ';
									echo anchor('admin/maintenance/export/'.$table['name'].'/json', lang('maintenance:export_json'), array('class'=>'button btn')).' ';
								endif ?>
							</td>
						</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			<?php endif;?>
		
		</div>
	</div>
 </div>

 <div class="accordion-group ">
	<div class="accordion-heading">
		<h4><?php echo lang('maintenance:list_label') ?></h4>
	</div>
	
	<div class="accordion-body collapse in lst">
		<div class="content">
	
			<?php if ( ! empty($folders)): ?>
				  <table class="table table-striped" cellspacing="0">
					<thead>
						<tr>
							<th><?php echo lang('name_label') ?></th>
							<th class="align-center"><?php echo lang('maintenance:count_label') ?></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($folders as $folder): ?>
						<tr>
							<td><?php echo $folder['name'] ?></td>
							<td class="align-center"><?php echo $folder['count'] ?></td>
							<td class="buttons buttons-small align-center actions">
								<?php if ($folder['count'] > 0) echo anchor('admin/maintenance/cleanup/'.$folder['name'], lang('global:empty'), array('class'=>'button empty btn')) ?>
								<?php if ( ! $folder['cannot_remove']) echo anchor('admin/maintenance/cleanup/'.$folder['name'].'/1', lang('global:remove'), array('class'=>'button remove btn btn-danger' )) ?>
							</td>
						</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			<?php else: ?>
				<div class="blank-slate">
					<h2><?php echo lang('maintenance:no_items') ?></h2>
				</div>
			<?php endif;?>
	
		</div>
	</div>
 
    </div>
<?= form_open('admin/packages/show'); ?>
	<table border="0" class="listTable">    
		<thead>
			<tr>
				<th class="first"><div></div></th>
				<th><a href="#"><?=lang('pack_package_label');?></a></th>
				<th><a href="#"><?=lang('pack_updated_label');?></a></th>
				<th class="last"><span><?=lang('pack_actions_label');?></span></th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<td colspan="4">
					<div class="inner"><? $this->load->view('admin/fragments/pagination'); ?></div>
				</td>
			</tr>
		</tfoot>  
		<tbody>
		<? if ($packages): ?>
			<? foreach ($packages as $package): ?>
				<? $featured = ($package->featured == 'Y') ? ' checked="checked"' : ''; ?>
				<tr>
					<td><input type="checkbox" name="featured[<?=$package->slug;?>]"<?=$featured;?> /></td>
					<td><?=$package->title;?></td>
					<td><?=date('M d, Y', $package->updated_on);?></td>
					<td>
						<?=anchor('packages/' . $package->slug, lang('pack_view_label'));?> | 
						<?=anchor('admin/packages/edit/' . $package->slug, lang('pack_edit_label'));?> | 
						<?=anchor('admin/packages/delete/' . $package->slug, lang('pack_delete_label'), array('class'=>'confirm'));?>
					</td>
				</tr>
			<? endforeach; ?>
		<? else: ?>
			<tr>
				<td colspan="4"><?=lang('pack_no_packages_error');?></td>
			</tr>
		<? endif;	?>
		</tbody>
	</table>
	
	<button type="submit" name="btnSave" class="button">
		<strong>
			<?=lang('pack_save_featured_label');?>
			<img class="icon" alt="" src="<?=image_url('admin/icons/accepted_48.png');?>" />
		</strong>
	</button>
<?= form_close(); ?>
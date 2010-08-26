<?php echo form_open('admin/files/folders');?>
	<h3><?php echo lang('files.folders.manage_title'); ?></h3>

	<div id="files_toolbar">
		<ul>
			<li><a href="<?php echo site_url('admin/files/folders/create');?>" id="new_folder"><?php echo lang('files.folders.create'); ?></a></li>
		</ul>
	</div>

		<?php if ( ! empty($file_folders)): ?>

			<?php
				$tmpl = array ( 'table_open'  => '<table border="0" class="table-list">' );
				$this->table->set_template($tmpl);
				$this->table->set_heading(
					form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')),
					lang('files.folders.name'),
					lang('files.folders.created'),
					'<span>'. lang('files.labels.action') .'</span>'
				);

					foreach ($file_folders as $folder)
					{
						$spcr = '&nbsp;&nbsp; &raquo; ';
						$indent = ($folder['parent_id'] != 0) ? repeater($spcr, $folder['depth']) : '';
						$edit = anchor('admin/files/folders/edit/' . $folder['id'], lang('files.labels.edit'), 'class="edit_folder"');
						$delete = anchor('admin/files/folders/delete/' . $folder['id'], lang('files.labels.delete'), array('class'=>'confirm'));
						$this->table->add_row(
						 	form_checkbox('action_to[]', $folder['id']),
						 	$indent.$folder['name'],
							date("m.d.y \a\\t g.i a", $folder['date_added']),
							$edit .' | '. $delete
						 );
					}

				echo $this->table->generate();
			?>

			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>

		<?php else: ?>
			<p><?php echo lang('files.folders.no_folders');?></p>
		<?php endif; ?>
<?php echo form_close();?>
<script type="text/javascript">
jQuery(function($) {
	$("#new_folder").colorbox({
		width:"400", height:"350", iframe:true,
		onClosed:function(){ location.reload(); }
	});
	$(".edit_folder").colorbox({
		width:"400", height:"350", iframe:true,
		onClosed:function(){ location.reload(); }
	});
});
</script>
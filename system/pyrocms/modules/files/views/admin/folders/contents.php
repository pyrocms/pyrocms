<?php echo form_open('admin/files/action');?>
	<h3>
		<?php echo $crumbs; ?>
		<span><a href="<?php echo site_url('admin/files/upload/'.$id);?>" id="new_files"><?php echo lang('files.upload.title'); ?></a></span>
        <a href="#" title="grid" class="toggle-view"><?php echo lang('files.grid'); ?></a>
        <a href="#" title="list" class="toggle-view active-view"><?php echo lang('files.list'); ?></a>
    </h3>

	<div id="files_toolbar">
		<ul>
			<li>
				<label for="folder"><?php echo lang('files.subfolders.label'); ?>:</label>
				<?php
				//$folder_options['0'] = $sub_folders[0];
				foreach($sub_folders as $row)
				{
					if ($row['name'] != '-') //$id OR $row['parent_id'] > 0)
					{
						$indent = ($row['parent_id'] != 0 && isset($row['depth'])) ? repeater('&nbsp;&raquo;&nbsp;', $row['depth']) : '';
						$folder_options[$row['id']] = $indent.$row['name'];
					}
				}
				echo form_dropdown('parent_id', $folder_options, $id, 'id="parent_id"');
				?>
			</li>
			<li>
				<label for="folder"><?php echo lang('files.filter'); ?>:</label>
				<?php echo form_dropdown('filter', array('' => '') + $types, $selected_filter, 'id="filter"'); ?>
			</li>
		</ul>
	</div>
	<?php if ( ! empty($files)): ?>
    <div id="grid">
        <?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'grid-check-all')); ?>
        <ul>
        <?php foreach($files as $file): ?>
            <li>
                <div class="actions">
                <?php echo form_checkbox('action_to[]', $file->id); ?>
                <?php echo anchor('files/download/' . $file->id, lang('files.labels.download'), array('class' => 'download_file')); ?>
                <?php echo anchor('admin/files/edit/' . $file->id, lang('files.labels.edit'), array('class' => 'edit_file')); ?>
                <?php echo anchor('admin/files/delete/' . $file->id, lang('files.labels.delete'), array('class'=>'confirm')); ?>
                </div>
            <?php if($file->type == 'i'): ?>
            <a title="<?php echo $file->name; ?>" href="<?php echo base_url() . 'uploads/files/' . $file->filename; ?>" rel="colorbox">
                <img title="<?php echo $file->name; ?>" height="64" src="<?php echo base_url() . 'uploads/files/' . $file->filename; ?>" alt="<?php echo $file->name; ?>" />
            </a>
            <?php else: ?>
                <?php echo image($file->type . '.png', 'files'); ?>
            <?php endif; ?>
            </li>
        <?php endforeach; ?>
        </ul>
    </div>
        <?php
			$tmpl = array ( 'table_open'  => '<table border="0" class="table-list" id="list">' );
			$this->table->set_template($tmpl);
			$this->table->set_heading(
				form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all')),
				lang('files.folders.name'),
				lang('files.type'),
				lang('files.file_name'),
				lang('files.folders.created'),
				'<span>'. lang('files.labels.action') .'</span>'
			);

				foreach ($files as $file)
				{
					$download = anchor('files/download/' . $file->id, lang('files.labels.download'), array('class' => 'download_file'));
					$edit = anchor('admin/files/edit/' . $file->id, lang('files.labels.edit'), array('class' => 'edit_file'));
					$delete = anchor('admin/files/delete/' . $file->id, lang('files.labels.delete'), array('class'=>'confirm'));
					$this->table->add_row(
					 	form_checkbox('action_to[]', $file->id),
					 	$file->name,
					 	lang('files.'.$file->type),
						$file->filename,
						format_date($file->date_added),
						$download .' | '. $edit .' | '. $delete
					 );
				}

			echo $this->table->generate();
		?>

        <br class="clear-both" />
        
		<div class="buttons buttons-small align-right padding-top">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))); ?>
		</div>
	<?php else: ?>
		<p><?php echo lang('files.no_files');?></p>
	<?php endif; ?>

<?php echo form_close();?>
<script type="text/javascript">
(function($) {
	$(function() {

		var curr_url = '<?php echo site_url('admin/files/folders/contents/'.$id.'/'.$selected_filter) ?>/';

		$('#parent_id').change(function() {
			curr_url = '<?php echo site_url('admin/files/folders/contents/') ?>/'+$(this).val()+'/<?php echo $selected_filter; ?>';
			curr_text = $(this).text();
			$(this).text("Loading...");
			$("#files_right_pane").load(curr_url);
			return false;
		});
		$('#filter').change(function() {
			curr_url = '<?php echo site_url('admin/files/folders/contents/'.$id) ?>/'+$(this).val();
			curr_text = $(this).text();
			$(this).text("Loading...");
			$("#files_right_pane").load(curr_url);
			return false;
		});
		$(".edit_file").colorbox({
			width:"600", height:"450", iframe:true,
			onClosed:function(){ $("#files_right_pane").load(curr_url); }
		});
		$("#new_files").colorbox({
			width:"600", height:"450", iframe:true,
			onClosed:function(){ $("#files_right_pane").load(curr_url); }
		});
        
        $('a[rel="colorbox"]').colorbox({
            maxWidth: "80%",
            maxHeight: "80%"
        });
        
        $('.grid-check-all').click(function() {
            $('#grid').find("input[type='checkbox']").each(function () {
				if($(".grid-check-all").is(":checked") && !$(this).is(':checked'))
				{
					$(this).click();
				}
				else if(!$(".grid-check-all").is(":checked") && $(this).is(':checked'))
				{
					$(this).click();
				}
			}); 
        });
        
        $('#grid').hide();
        
        $('a.toggle-view').click(function(e) {
            e.preventDefault();
            view = $(this).attr('title');
            $('a.active-view').removeClass('active-view');
            $(this).addClass('active-view');
            
            if(view == 'grid')
            {
                hide_view = 'list';
            }
            else
            {
                hide_view = 'grid';
            }
            
            $('#'+hide_view).fadeOut(1000, function() {
                $('#'+view).fadeIn(700);   
            });            
        });
        
	});
})(jQuery);
</script>

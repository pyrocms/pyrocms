<div class="box">
	<h3><?php echo lang('photo_albums.add_photo_title');?></h3>
	
	<div class="box-container">
	
		<?php echo form_open_multipart('admin/photos/upload/' . $this->uri->segment(4), array('class' => "crud")); ?>
	
			<ol class="spacer-bottom">
				<li>
					<label><?php echo lang('photos.photo_label');?></label>
					<?php echo form_upload('userfile'); ?>
				</li>
				
				<li class="even">
					<label><?php echo lang('photos.desc_label');?></label>
					<?php echo form_input('description', set_value('description'), 'maxlength="100"'); ?>
					<span class="required-icon tooltip"><?php echo lang('required_label');?></span>
				</li>
			</ol>
		
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
	
		<?php echo form_close();?>
	</div>	
</div>


<?php if ($photos): ?> 

	<div class="box">
		
		<h3><?php echo lang('photo_albums.manage_title');?></h3>
	
		<div class="box-container">
			<?php echo form_open('admin/photos/delete_photo');?>
				<?php echo form_hidden('album', $album->id);?>
				
					<ul id="photo-list" class="list-unstyled">
						<?php foreach($photos as $photo): ?>
							<li class="float-left align-center spacer-right" style="height:150px">
								<a href="<?php echo image_path('photos/'.$album->id .'/' . $photo->filename); ?>" title="<?php echo $photo->description;?>" rel="modal">
									<?php echo image('photos/' . $album->id . '/' . substr($photo->filename, 0, -4) . '_thumb' . substr($photo->filename, -4), '', array('alt' => $photo->description));?>
								</a><br />
								<?php echo form_checkbox('action_to[]', $photo->id); ?>
							</li>
						<?php endforeach; ?>
					</ul>
						
				<br class="clear-both" />
				<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete') )); ?>
			<?php echo form_close(); ?>
		</div>
	</div>
	
	<script type="text/javascript">
	(function($) {
		$(function() {

			var store_func = function() {};
			
			$('ul#photo-list').sortable({
				handle: 'img',
				start: function(event, ui) {
					ui.helper.find('a').unbind('click').die('click');
				},
				update: function() {
					order = new Array();
					$('li', this).each(function(){
						order.push( $(this).find('input[name="action_to[]"]').val() );
					});
					order = order.join(',');
					
					$.post(BASE_URI + 'admin/photos/ajax_update_order', { order: order });

					/*
					$(this).find('a').fancybox({
						overlayOpacity: 0.8,
						overlayColor: '#000',
						hideOnContentClick: false
					});
					*/
				}
				
			}).disableSelection();
					
		});
	})(jQuery);
	</script>
<?php endif; ?>
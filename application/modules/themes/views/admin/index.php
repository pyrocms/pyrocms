<div class="box">
	<h3><?php echo lang('themes.list_label');?></h3>
	
	<div class="box-container">

		<div class="button float-right" style="margin-top: -3.4em;">
			<?php echo anchor('admin/themes/upload', lang('themes.upload_title')); ?>
		</div>

		<?php echo form_open('admin/themes/set_default'); ?>

			<style type="text/css">
				.theme { 
					background-color:#efefef;
					-moz-border-radius: 5px;
					-webkit-border-radius: 5px;
					cursor: pointer;
					display:block;
					float:left;
					margin:0.5em;
					padding:0 1em;
					text-align:center;
					width:23.1em;
				}
				.theme:hover { background-color: lightyellow; }
				.theme.selected { background-color: #3A4043; color: #fff; }
				.theme a {color: inherit;}
			</style>

			<script type="text/javascript">
				(function($)
				{
					$(function() {
						$('div.theme').click(function(){
							$('.theme').removeClass('selected');
							$(this).addClass('selected');
							$('input[name="theme"]').val( this.id.replace(/^theme-/, '') );
						});
					});
				})(jQuery);
			</script>

			<?php echo form_hidden('theme', $this->settings->item('default_theme')); ?>

			<?php if(!empty($themes)): ?>

				<?php foreach($themes as $theme): ?>

					<div id="theme-<?php echo $theme->slug; ?>" class="theme <?php echo $this->settings->item('default_theme') == $theme->slug ? 'selected' : ''; ?>">
						<h4 class="header">
							<?php if (!empty($theme->website)): ?>
								<?php echo anchor($theme->website, $theme->name, array('target'=>'_blank')); ?>
							<?php else: ?>
								<?php echo $theme->name; ?>
							<?php endif; ?>
							 by
							<?php if ($theme->author_website): ?>
								<?php echo anchor($theme->author_website, $theme->author, array('target'=>'_blank')); ?>
							<?php else: ?>
								<?php echo $theme->author; ?>
							<?php endif; ?>
						</h4>

						<img src="<?php echo $theme->screenshot; ?>" alt="<?php echo $theme->name; ?>" width="180" height="140" />
						<p><em>version <?php echo $theme->version; ?></em></p>
						<p><?php echo $theme->description; ?></p>

					</div>

						<?php echo alternator('', '', '<br class="clear-both" />'); ?>
				<?php endforeach; ?>

				<br class="clear-both" />
				
			<?php else: ?>
				<p><?php echo lang('themes.no_themes_installed');?></p>
			<?php endif; ?>
			
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save') )); ?>
		
		<?php echo form_close(); ?>
		
	</div>
</div>
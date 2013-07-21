<?php if (! isset($template['partials']['alternate_header'])): ?>
<section class="information padded">

	<div class="pull-left">

		<h2>
			<?php echo $module_details['name'] ? anchor('admin/'.$module_details['slug'], $module_details['name']) : lang('global:dashboard') ?>

			<small class="hidden-phone">
				<?php 
					if ( $this->uri->segment(2) ) 
					{ 
						echo '<small>&nbsp; | &nbsp;</small>'; 
						echo $module_details['description'] ? $module_details['description'] : '';
						if($module_details['slug'])
						{
							echo '<small>&nbsp; | &nbsp;</small>' .anchor('admin/help/'.$module_details['slug'], lang('help_label'), array(
								'title' => $module_details['name'].' '.lang('help_label'), 'data-toggle' => 'modal'));
						}
					}
				?>
			</small>
			
		</h2>

	</div>

	<?php file_partial('shortcuts') ?>

	<div class="clearfix"/>

</section>
<?php else: ?>
	<?php echo $template['partials']['alternate_header']; ?>
<?php endif; ?>


<?php if ( ! empty($module_details['sections'])) file_partial('sections'); ?>
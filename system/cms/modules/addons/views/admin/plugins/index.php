<section class="padded">
<div class="container-fluid">


	<!-- Box -->
	<section class="box">

		<!-- Header -->
		<section class="box-header">
			<span class="title"><?php echo lang('global:plugins');?></span>
		</section>


		<!-- Box Content -->
		<section class="box-content">

			<h4 class="margin-small margin-top margin-bottom"><?php echo lang('addons:plugins:add_on_plugins');?></h4>
			<?php echo $this->load->view('admin/plugins/_table', array('plugins' => $plugins), true) ?>

			<h4 class="margin-small margin-top margin-bottom"><?php echo lang('addons:plugins:core_plugins');?></h4>
			<?php echo $this->load->view('admin/plugins/_table', array('plugins' => $core_plugins), true) ?>

			
			<section class="hidden">
				<?php echo $this->load->view('admin/plugins/_docs', array('plugins' => array($plugins, $core_plugins)), true) ?>
			</section>

		</section>
		<!-- /Box Content -->

	</section>
	<!-- /Box -->


</section>
</div>
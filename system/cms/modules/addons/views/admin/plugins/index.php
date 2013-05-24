<section class="content-wrapper">
<div class="container-fluid">


	<section class="box">

		<section class="box-header">
			<span class="title"><?php echo lang('global:plugins');?></span>
		</section>
		
		<div class="box-content">
			
			<h4><?php echo lang('addons:plugins:add_on_plugins');?></h4>
			<?php echo $this->load->view('admin/plugins/_table', array('plugins' => $plugins), true) ?>
			

			<h4><?php echo lang('addons:plugins:core_plugins');?></h4>
			<?php echo $this->load->view('admin/plugins/_table', array('plugins' => $core_plugins), true) ?>

		</div>

	</section>

	<section id="plugin-docs" style="display:none">
		<?php echo $this->load->view('admin/plugins/_docs', array('plugins' => array($plugins, $core_plugins)), true) ?>
	</section>


</div>
</section>
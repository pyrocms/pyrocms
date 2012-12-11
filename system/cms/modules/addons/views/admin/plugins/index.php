<section class="title">
	<h4><?php echo lang('global:plugins');?></h4>
</section>

<section class="item">

<h4><?php echo lang('addons:plugins:add_on_plugins');?></h4>
<?php echo $this->load->view('admin/plugins/_table', array('plugins' => $plugins), true) ?>

<h4><?php echo lang('addons:plugins:core_plugins');?></h4>
<?php echo $this->load->view('admin/plugins/_table', array('plugins' => $core_plugins), true) ?>

</section>
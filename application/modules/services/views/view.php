<h2><?php echo $service->title; ?></h2>
<strong><?php echo lang('service_price_label');?>: <?php echo sprintf(lang('service_price_format'), $this->settings->item('currency'), $service->price, $service->pay_per);?></strong>
<p><?php echo $service->description; ?></p>
<h2><?= $service->title; ?></h2>
<strong><?=lang('service_price_label');?>: <?=sprintf(lang('service_price_format'), $this->settings->item('currency'), $service->price, $service->pay_per);?></strong>
<p><?= $service->description; ?></p>
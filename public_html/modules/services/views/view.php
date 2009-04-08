
<h2><?= $service->title; ?></h2>

<strong>Price: <?= $this->settings->item('currency').$service->price; ?> per <?= $service->pay_per; ?></strong>

<p><?= $service->description; ?></p>

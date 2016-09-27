<?php

return [
    'admin/orders/orders' => 'Anomaly\OrdersModule\Http\Controller\Admin\OrdersController@index',
    'admin/orders/orders/create' => 'Anomaly\OrdersModule\Http\Controller\Admin\OrdersController@create',
    'admin/orders/orders/edit/{id}' => 'Anomaly\OrdersModule\Http\Controller\Admin\OrdersController@edit'
];

<?php

$this->load->model('extension/event');

$this->model_extension_event->deleteEvent('mail-customer-add');
$this->model_extension_event->addEvent('mail-customer-add', 'catalog/model/account/customer/addCustomer/after', 'event/mail/addCustomer');

$this->model_extension_event->deleteEvent('mail-forgotton');
$this->model_extension_event->addEvent('mail-forgotton', 'catalog/model/account/customer/editCode/after', 'event/mail/forgotten');

$this->model_extension_event->deleteEvent('mail-order-before');
$this->model_extension_event->addEvent('mail-order-before', 'catalog/model/checkout/order/addOrderHistory/before', 'event/mail/orderBefore');
$this->model_extension_event->deleteEvent('mail-order-after');
$this->model_extension_event->addEvent('mail-order-after', 'catalog/model/checkout/order/addOrderHistory/after', 'event/mail/orderAfter');

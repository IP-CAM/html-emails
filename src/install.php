<?php

$this->event->removeEvent('mail-customer-add');
$this->event->addEvent('mail-customer-add', 'catalog/model/account/customer/addCustomer/after', 'event/mail/addCustomer');

$this->event->removeEvent('mail-forgotton');
$this->event->addEvent('mail-forgotton', 'catalog/model/account/customer/editCode/after', 'event/mail/forgotten');

$this->event->removeEvent('mail-order-before');
$this->event->addEvent('mail-order-before', 'catalog/model/checkout/order/addOrderHistory/before', 'event/mail/orderBefore');
$this->event->removeEvent('mail-order-after');
$this->event->addEvent('mail-order-after', 'catalog/model/checkout/order/addOrderHistory/after', 'event/mail/orderAfter');

<?php

class ControllerEventMail extends Controller {

    public function orderAfter($route, $data) {
		$this->load->model('mail/order');
		$this->model_mail_order->triggerMail($route, $data);
    }

    /**
     * Email new order
     */
	public function orderBefore($route, $data) {
		$this->load->model('checkout/order');
        $order_info = $this->model_checkout_order->getOrder($order_id);
		$this->session->data['before_order_status_id'] = $order_info['order_status_id'];
    }

    /**
     * Email account forgotten
     */
    public function forgotten($route, $data) {
        $this->load->model('mail/forgotten');
		$this->model_mail_forgotten->triggerMail($route, $data);
    }

    /**
     * Email after a customer is added
     */
	public function addCustomer($route, $data, $result) {        
		$this->load->model('mail/account');
		$this->model_mail_account->triggerMail($route, $data, $result);
	}

}
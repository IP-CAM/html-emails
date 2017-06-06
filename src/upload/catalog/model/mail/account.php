<?php

class ModelMailAccount extends MailTemplate {

    public function triggerMail($route, $data = null, $result = null) {
        $this->load->model('account/customer');
		$this->load->model('account/customer_group');
        $customer = $this->model_account_customer->getCustomer($result);
		$customer_group_info = $this->model_account_customer_group->getCustomerGroup($customer['customer_group_id']);		
        $this->load->language('mail/customer');

		$subject = sprintf($this->language->get('text_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
		
        // text mail
        $message = sprintf($this->language->get('text_welcome'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8')) . "\n\n";
		if (!$customer_group_info['approval']) {
			$message .= $this->language->get('text_login') . "\n";
		} else {
			$message .= $this->language->get('text_approval') . "\n";
		}
		$message .= $this->url->link('account/login', '', true) . "\n\n";
		$message .= $this->language->get('text_services') . "\n\n";
		$message .= $this->language->get('text_thanks') . "\n";
		$message .= html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8');

        // html mail
        $htmlMailData['welcome'] = sprintf($this->language->get('text_welcome'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
        if (!$customer_group_info['approval']) {
			$htmlMailData['text'] = $this->language->get('text_login');
		} else {
			$htmlMailData['text'] = $this->language->get('text_approval');
		}
		$htmlMailData['link'] = $this->url->link('account/login', '', true);
		$htmlMailData['services'] = $this->language->get('text_services');
		$htmlMailData['thanks'] = $this->language->get('text_thanks') . "<br>" . html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8');
        $this->attachHeader($htmlMailData);
        $this->attachFooter($htmlMailData);

        $this->sendMail(
            $customer['email'] ,
            $subject ,
            $message ,
            $this->load->view('mail/account', $htmlMailData)
        );
        
        // Send to main admin email if new account email is enabled
        if (in_array('account', (array)$this->config->get('config_mail_alert'))) {
            $message  = $this->language->get('text_signup') . "\n\n";
            $message .= $this->language->get('text_website') . ' ' . html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8') . "\n";
            $message .= $this->language->get('text_firstname') . ' ' . $data['firstname'] . "\n";
            $message .= $this->language->get('text_lastname') . ' ' . $data['lastname'] . "\n";
            $message .= $this->language->get('text_customer_group') . ' ' . $customer_group_info['name'] . "\n";
            $message .= $this->language->get('text_email') . ' '  .  $data['email'] . "\n";
            $message .= $this->language->get('text_telephone') . ' ' . $data['telephone'] . "\n";
            $this->sendAdminMails(html_entity_decode($this->language->get('text_new_customer'), ENT_QUOTES, 'UTF-8'), $message);
        }
    }

}

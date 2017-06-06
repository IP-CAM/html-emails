<?php

abstract class MailTemplate extends Model {

    abstract public function triggerMail($route, $data = null, $result = null);

    public function sendMail($to, $subject, $text, $html = null) {
        $mail = new Mail();
        $mail->protocol = $this->config->get('config_mail_protocol');
        $mail->parameter = $this->config->get('config_mail_parameter');
        $mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
        $mail->smtp_username = $this->config->get('config_mail_smtp_username');
        $mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
        $mail->smtp_port = $this->config->get('config_mail_smtp_port');
        $mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');
        $mail->setTo($to);
        $mail->setFrom($this->config->get('config_email'));
        $mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
        $mail->setSubject($subject);
        $mail->setText($text);
        
        if ($html) {
            $mail->setHtml($html);
        }
        
        $mail->send();
    }

    public function sendAdminMails($subject, $text, $html = null) {		
        $this->sendMail(
            $this->config->get('config_email'),
            html_entity_decode($this->language->get('text_new_customer'), ENT_QUOTES, 'UTF-8'),
            $text,
            $html
        );

        // Send to additional alert emails if new account email is enabled
        $emails = explode(',', $this->config->get('config_alert_email'));
        foreach ($emails as $email) {
            if (utf8_strlen($email) > 0 && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->sendMail(
                    $email,
                    html_entity_decode($this->language->get('text_new_customer'), ENT_QUOTES, 'UTF-8'),
                    $text,
                    $html
                );
            }
        }		
    }

    public function attachHeader(&$data) {
        $data['logo'] = $this->config->get('config_url') . 'image/' . $this->config->get('config_logo');
        $data['store_name'] = html_entity_decode($this->config->get('config_name'));
    }

    public function attachFooter(&$data) {
        $this->load->language('common/footer');

        $data['text_information'] = $this->language->get('text_information');
		$data['text_service'] = $this->language->get('text_service');
        $data['text_contact'] = $this->language->get('text_contact');
		$data['text_return'] = $this->language->get('text_return');
		$data['text_sitemap'] = $this->language->get('text_sitemap');

        $data['informations'] = "";

		foreach ($this->model_catalog_information->getInformations() as $result) {
			if ($result['bottom']) {
                $data['informations'] .= '<a style="color:white;" href="'.$this->url->link('information/information', 'information_id=' . $result['information_id']).'">'.$result['title'].'</a><br/>';
			}
		}

		$data['contact'] = $this->url->link('information/contact');
		$data['return'] = $this->url->link('account/return/add', '', true);
		$data['sitemap'] = $this->url->link('information/sitemap');
        $data['address'] = nl2br($this->config->get('config_address'));
    }

}
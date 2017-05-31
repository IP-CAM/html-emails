<?php

class ModelMailForgotten extends MailTemplate {

    public function triggerMail(&$route, &$data = null, &$result = null) {
        $this->load->language('mail/forgotten');
        $subject = sprintf($this->language->get('text_subject'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));

        // text mail
        $message  = sprintf($this->language->get('text_greeting'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8')) . "\n\n";
        $message .= $this->language->get('text_change') . "\n";
        $message .= $this->url->link('account/reset', 'code=' . $code, true) . "\n\n";
        $message .= sprintf($this->language->get('text_ip'), $this->request->server['REMOTE_ADDR']) . "\n\n";

        // html mail
        $htmlMailData['text_greeting'] = sprintf($this->language->get('text_greeting'), html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
		$htmlMailData['text_change'] = $this->language->get('text_change');
        $htmlMailData['link'] = $this->url->link('account/reset', 'code=' . $code, true);
        $htmlMailData['text_ip'] = sprintf($this->language->get('text_ip'), $this->request->server['REMOTE_ADDR']);
        $this->attachHeader($htmlMailData);
        $this->attachFooter($htmlMailData);

        $this->sendMail(
            $data[0] ,
            $subject ,
            $message ,
            $this->load->view('mail/forgotten', $htmlMailData)
        );
    }

}
